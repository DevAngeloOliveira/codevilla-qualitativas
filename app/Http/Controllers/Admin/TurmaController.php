<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Turma;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TurmasExport;

class TurmaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $turmas = Turma::with('alunos')
            ->withCount('alunos')
            ->ordenadas()
            ->paginate(20);

        return Inertia::render('Admin/Turmas/Index', [
            'turmas' => $turmas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Turmas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:50',
            'ano_letivo' => 'required|integer|digits:4',
            'turno' => 'required|in:Matutino,Vespertino',
            'segmento' => 'nullable|string|max:100',
        ]);

        $validated['ativa'] = true;
        $validated['segmento'] = $validated['segmento'] ?? 'Ensino Fundamental II';

        Turma::create($validated);

        return redirect()->route('admin.turmas.index')
            ->with('success', 'Turma criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turma $turma)
    {
        $turma->load('alunos');

        return Inertia::render('Admin/Turmas/Edit', [
            'turma' => $turma,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turma $turma)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:50',
            'ano_letivo' => 'required|integer|digits:4',
            'turno' => 'required|in:Matutino,Vespertino',
            'segmento' => 'nullable|string|max:100',
            'ativa' => 'boolean',
        ]);

        $validated['segmento'] = $validated['segmento'] ?? 'Ensino Fundamental II';

        $turma->update($validated);

        return redirect()->route('admin.turmas.index')
            ->with('success', 'Turma atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turma $turma)
    {
        // Verificar se há alunos na turma
        if ($turma->alunos()->count() > 0) {
            return redirect()->back()->withErrors([
                'error' => 'Não é possível excluir uma turma com alunos cadastrados.'
            ]);
        }

        $turma->delete();

        return redirect()->route('admin.turmas.index')
            ->with('success', 'Turma excluída com sucesso!');
    }

    /**
     * Exibir detalhes da turma com lista de alunos
     */
    public function detalhes(Turma $turma)
    {
        $turma->load(['alunos' => function ($query) {
            $query->orderBy('numero_chamada');
        }]);

        return Inertia::render('Admin/Turmas/Detalhes', [
            'turma' => $turma,
        ]);
    }

    /**
     * Adicionar aluno à turma
     */
    public function adicionarAluno(Request $request, Turma $turma)
    {
        $validated = $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'numero_chamada' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($turma) {
                    $exists = Aluno::where('turma_id', $turma->id)
                        ->where('numero_chamada', $value)
                        ->exists();
                    if ($exists) {
                        $fail('Este número de chamada já está sendo usado nesta turma.');
                    }
                },
            ],
            'foto' => 'nullable|image|max:5120|mimes:jpg,jpeg,png,webp',
        ]);

        $aluno = new Aluno();
        $aluno->nome = $validated['nome'];
        $aluno->turma_id = $turma->id;
        $aluno->numero_chamada = $validated['numero_chamada'];

        // Processar upload de foto se houver
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = 'aluno_' . uniqid() . '.webp';

            $manager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $image = $manager->read($foto->getPathname());
            $image->cover(400, 400);

            $path = 'fotos/alunos/' . $filename;
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $image->toWebp(85)->toString());

            $aluno->foto = $path;
        }

        $aluno->save();

        return redirect()->back()
            ->with('success', 'Aluno adicionado com sucesso!');
    }

    /**
     * Remover aluno da turma
     */
    public function removerAluno(Turma $turma, Aluno $aluno)
    {
        // Verificar se o aluno pertence à turma
        if ($aluno->turma_id !== $turma->id) {
            return redirect()->back()->withErrors([
                'error' => 'Este aluno não pertence a esta turma.'
            ]);
        }

        // Deletar foto se existir
        if ($aluno->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($aluno->foto)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($aluno->foto);
        }

        $aluno->delete();

        return redirect()->back()
            ->with('success', 'Aluno removido com sucesso!');
    }

    /**
     * Exportar turmas para PDF
     * Aceita parâmetro 'turmas' com array de UUIDs para exportar turmas específicas
     */
    public function exportPdf(Request $request)
    {
        $query = Turma::with(['alunos' => function ($query) {
            $query->orderBy('numero_chamada');
        }])
            ->withCount('alunos')
            ->ordenadas();

        // Se foi passado array de UUIDs de turmas, filtra apenas essas
        if ($request->has('turmas') && is_array($request->turmas) && count($request->turmas) > 0) {
            $query->whereIn('uuid', $request->turmas);
        }

        $turmas = $query->get();

        // Caminho da logo
        $logoPath = public_path('assets/images/logo-codevilla.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = base64_encode(file_get_contents($logoPath));
        }

        $pdf = Pdf::loadView('exports.turmas-pdf', [
            'turmas' => $turmas,
            'logoBase64' => $logoBase64
        ])
            ->setPaper('a4', 'portrait');

        $filename = 'relacao-turmas-' . now()->format('Y-m-d') . '.pdf';
        return $pdf->download($filename);
    }

    /**
     * Exportar turmas para Excel
     */
    public function exportExcel()
    {
        return Excel::download(new TurmasExport, 'relacao-turmas-' . now()->format('Y-m-d') . '.xlsx');
    }
}
