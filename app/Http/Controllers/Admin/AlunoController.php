<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Alunos\Models\Aluno;
use App\Domains\Alunos\Models\Turma;
use App\Domains\Alunos\Services\AlunoService;
use App\Domains\Alunos\Services\TurmaService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class AlunoController extends Controller
{
    public function __construct(
        private readonly AlunoService $alunoService,
        private readonly TurmaService $turmaService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->alunoService->query()->with('turma');

        // Filtro por busca (nome ou número de chamada)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                    ->orWhere('numero_chamada', 'like', "%{$search}%");
            });
        }

        // Filtro por turma
        if ($request->filled('turma_id')) {
            $query->where('turma_id', $request->turma_id);
        }

        // Ordenação
        $sortBy = $request->get('sort_by', 'nome');
        $sortOrder = $request->get('sort_order', 'asc');

        if ($sortBy === 'turma') {
            $query->join('turmas', 'alunos.turma_id', '=', 'turmas.id')
                ->select('alunos.*', 'turmas.nome as turma_nome')
                ->orderBy('turma_nome', $sortOrder);
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Paginação configurável
        $perPage = $request->get('per_page', 12);
        $alunos = $query->paginate($perPage)->withQueryString();

        $turmas = $this->turmaService->query()->orderBy('nome')->get();
        $turma = $request->turma_id ? $this->turmaService->find($request->turma_id) : null;

        return Inertia::render('Admin/Alunos/Index', [
            'alunos' => $alunos,
            'turmas' => $turmas,
            'turma' => $turma,
            'filters' => [
                'search' => $request->search,
                'turma_id' => $request->turma_id,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
                'per_page' => $perPage,
            ],
            'stats' => [
                'total' => $this->alunoService->count(),
                'por_turma' => $this->turmaService->query()->withCount('alunos')->get()->pluck('alunos_count', 'nome'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Turma $turma)
    {
        return Inertia::render('Admin/Alunos/Create', [
            'turma' => $turma,
        ]);
    }

    /**
     * Calcula o número de chamada automático baseado na ordem alfabética
     */
    private function calcularNumeroChamada(string $nome, int $turmaId, ?int $alunoId = null): int
    {
        // Buscar todos os alunos da turma exceto o que está sendo editado
        $query = $this->alunoService->query()->where('turma_id', $turmaId);

        if ($alunoId) {
            $query->where('id', '!=', $alunoId);
        }

        $alunosExistentes = $query->get()->pluck('nome')->toArray();

        // Adicionar o novo nome à lista
        $alunosExistentes[] = $nome;

        // Ordenar alfabeticamente (case-insensitive, normalizado)
        usort($alunosExistentes, function ($a, $b) {
            return strcoll(
                mb_strtolower($this->removerAcentos($a)),
                mb_strtolower($this->removerAcentos($b))
            );
        });

        // Encontrar a posição do aluno na lista ordenada
        $posicao = array_search($nome, $alunosExistentes);

        return $posicao + 1; // Número de chamada começa em 1
    }

    /**
     * Remove acentos para ordenação consistente
     */
    private function removerAcentos(string $string): string
    {
        $acentos = [
            'á' => 'a',
            'à' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'ä' => 'a',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'í' => 'i',
            'ì' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'ó' => 'o',
            'ò' => 'o',
            'õ' => 'o',
            'ô' => 'o',
            'ö' => 'o',
            'ú' => 'u',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'ç' => 'c',
            'ñ' => 'n',
            'Á' => 'A',
            'À' => 'A',
            'Ã' => 'A',
            'Â' => 'A',
            'Ä' => 'A',
            'É' => 'E',
            'È' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'Í' => 'I',
            'Ì' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'Ó' => 'O',
            'Ò' => 'O',
            'Õ' => 'O',
            'Ô' => 'O',
            'Ö' => 'O',
            'Ú' => 'U',
            'Ù' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'Ç' => 'C',
            'Ñ' => 'N',
        ];

        return strtr($string, $acentos);
    }

    /**
     * Reorganiza os números de chamada de todos os alunos da turma
     */
    private function reorganizarNumerosChamada(int $turmaId): void
    {
        $alunos = $this->alunoService->query()->where('turma_id', $turmaId)->get();

        // Ordenar alfabeticamente
        $alunosOrdenados = $alunos->sortBy(function ($aluno) {
            return mb_strtolower($this->removerAcentos($aluno->nome));
        })->values();

        // Usar transação para evitar conflitos de constraint
        \DB::transaction(function () use ($alunosOrdenados) {
            // Primeira passagem: atribuir números temporários negativos
            foreach ($alunosOrdenados as $index => $aluno) {
                $aluno->numero_chamada = - ($index + 1);
                $aluno->save();
            }

            // Segunda passagem: atribuir números finais positivos
            foreach ($alunosOrdenados as $index => $aluno) {
                $aluno->numero_chamada = $index + 1;
                $aluno->save();
            }
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Turma $turma)
    {
        $validated = $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'foto' => 'nullable|image|max:5120|mimes:jpg,jpeg,png,webp',
        ]);

        $aluno = new Aluno();
        $aluno->nome = $validated['nome'];
        $aluno->turma_id = $turma->id;

        // Atribuir numero_chamada temporário = total de alunos + 1
        // Será reorganizado logo após o save()
        $totalAlunos = $this->alunoService->countByTurma($turma->id);
        $aluno->numero_chamada = $totalAlunos + 1;

        // Gerar UUID antes de processar a foto
        if (empty($aluno->uuid)) {
            $aluno->uuid = (string) \Illuminate\Support\Str::uuid();
        }

        // Processar upload de foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = 'aluno_' . $aluno->uuid . '.webp';

            // Criar ImageManager com driver GD
            $manager = new ImageManager(new Driver());

            // Redimensionar e otimizar imagem
            $image = $manager->read($foto->getPathname());
            $image->cover(400, 400);

            // Salvar no storage público
            $path = 'fotos/alunos/' . $filename;
            $encodedImage = $image->toWebp(85);
            Storage::disk('public')->put($path, (string) $encodedImage);

            $aluno->foto = $path;
        }

        $aluno->save();

        // Reorganizar TODOS os números de chamada da turma em ordem alfabética
        $this->reorganizarNumerosChamada($turma->id);

        return redirect()->route('admin.turmas.detalhes', $turma->uuid)
            ->with('success', 'Aluno cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aluno $aluno)
    {
        $aluno->load('turma');

        return Inertia::render('Admin/Alunos/Show', [
            'aluno' => $aluno,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aluno $aluno)
    {
        $aluno->load('turma');

        return Inertia::render('Admin/Alunos/Edit', [
            'aluno' => $aluno,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aluno $aluno)
    {
        $validated = $request->validate([
            'nome' => 'required|string|min:3|max:255',
            'foto' => 'nullable|image|max:5120|mimes:jpg,jpeg,png,webp',
        ]);

        $nomeAnterior = $aluno->nome;
        $aluno->nome = $validated['nome'];

        // Processar upload de nova foto
        if ($request->hasFile('foto')) {
            // Deletar foto antiga se existir
            if ($aluno->foto && Storage::disk('public')->exists($aluno->foto)) {
                Storage::disk('public')->delete($aluno->foto);
            }

            $foto = $request->file('foto');
            $filename = 'aluno_' . $aluno->uuid . '.webp';

            // Criar ImageManager com driver GD
            $manager = new ImageManager(new Driver());

            // Redimensionar e otimizar imagem
            $image = $manager->read($foto->getPathname());
            $image->cover(400, 400);

            // Salvar no storage público
            $path = 'fotos/alunos/' . $filename;
            $encodedImage = $image->toWebp(85);
            Storage::disk('public')->put($path, (string) $encodedImage);

            $aluno->foto = $path;
        }

        $aluno->save();

        // Se o nome mudou, reorganizar números de chamada
        if ($nomeAnterior !== $validated['nome']) {
            $this->reorganizarNumerosChamada($aluno->turma_id);
        }

        return redirect()->route('admin.alunos.index')
            ->with('success', 'Aluno atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aluno $aluno)
    {
        // Deletar foto se existir
        if ($aluno->foto && Storage::disk('public')->exists($aluno->foto)) {
            Storage::disk('public')->delete($aluno->foto);
        }

        $turmaId = $aluno->turma_id;
        $aluno->delete();

        // Reorganizar números de chamada após exclusão
        $this->reorganizarNumerosChamada($turmaId);

        return redirect()->route('admin.alunos.index')
            ->with('success', 'Aluno excluído com sucesso!');
    }

    /**
     * Exibir detalhes completos do aluno
     */
    public function detalhes(Aluno $aluno)
    {
        $aluno->load(['turma', 'avaliacoes.disciplina', 'avaliacoes.criterios']);

        // Estatísticas do aluno
        $stats = [
            'total_avaliacoes' => $aluno->avaliacoes()->count(),
            'media_geral' => $aluno->avaliacoes()->avg('nota_final') ?? 0,
            'avaliacoes_por_disciplina' => $aluno->avaliacoes()
                ->with('disciplina')
                ->get()
                ->groupBy('disciplina.nome')
                ->map(function ($avaliacoes) {
                    return [
                        'total' => $avaliacoes->count(),
                        'media' => $avaliacoes->avg('nota_final'),
                    ];
                }),
        ];

        return Inertia::render('Admin/Alunos/Detalhes', [
            'aluno' => $aluno,
            'stats' => $stats,
        ]);
    }
}
