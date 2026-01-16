<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Disciplinas\Models\Disciplina;
use App\Domains\Disciplinas\Services\DisciplinaService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DisciplinaController extends Controller
{
    public function __construct(private readonly DisciplinaService $disciplinaService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $this->disciplinaService->query();

        // Busca
        if ($request->filled('search')) {
            $query->where('nome', 'like', '%' . $request->search . '%');
        }

        $disciplinas = $query->orderBy('nome')->paginate(15);

        return Inertia::render('Admin/Disciplinas/Index', [
            'disciplinas' => $disciplinas,
            'filters' => $request->only(['search']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Disciplinas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255|unique:disciplinas,nome',
        ]);

        $this->disciplinaService->query()->create($validated);

        return redirect()->route('admin.disciplinas.index')
            ->with('success', 'Disciplina criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Disciplina $disciplina)
    {
        return Inertia::render('Admin/Disciplinas/Show', [
            'disciplina' => $disciplina,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disciplina $disciplina)
    {
        return Inertia::render('Admin/Disciplinas/Edit', [
            'disciplina' => $disciplina,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Disciplina $disciplina)
    {
        $validated = $request->validate([
            'nome' => ['required', 'string', 'max:255', Rule::unique('disciplinas')->ignore($disciplina->id)],
        ]);

        $disciplina->update($validated);

        return redirect()->route('admin.disciplinas.index')
            ->with('success', 'Disciplina atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disciplina $disciplina)
    {
        // Verificar se há atribuições
        $hasAtribuicoes = DB::table('professor_turma')
            ->where('disciplina_id', $disciplina->id)
            ->exists();

        if ($hasAtribuicoes) {
            return back()->with('error', 'Não é possível remover esta disciplina pois ela possui atribuições.');
        }

        $disciplina->delete();

        return redirect()->route('admin.disciplinas.index')
            ->with('success', 'Disciplina removida com sucesso!');
    }
}
