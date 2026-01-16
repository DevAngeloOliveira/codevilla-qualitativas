<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Disciplinas\Services\DisciplinaService;
use App\Domains\Alunos\Services\TurmaService;
use App\Domains\Usuarios\Models\User;
use App\Domains\Usuarios\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AtribuicaoController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly TurmaService $turmaService,
        private readonly DisciplinaService $disciplinaService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $atribuicoes = DB::table('professor_turma')
            ->join('users', 'professor_turma.user_id', '=', 'users.id')
            ->join('turmas', 'professor_turma.turma_id', '=', 'turmas.id')
            ->join('disciplinas', 'professor_turma.disciplina_id', '=', 'disciplinas.id')
            ->select(
                'professor_turma.id',
                'users.name as professor_nome',
                'turmas.nome as turma_nome',
                'turmas.turno as turma_turno',
                'turmas.ano_letivo',
                'disciplinas.nome as disciplina_nome',
                'professor_turma.created_at'
            )
            ->orderBy('turmas.ano_letivo', 'desc')
            ->orderBy('turmas.nome')
            ->orderBy('disciplinas.nome')
            ->paginate(20);

        return Inertia::render('Admin/Atribuicoes/Index', [
            'atribuicoes' => $atribuicoes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $professores = $this->userService->query()->where('role', 'professor')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        $turmas = $this->turmaService->query()->where('ativa', true)
            ->ordenadas()
            ->get(['id', 'nome', 'ano_letivo', 'turno']);

        $disciplinas = $this->disciplinaService->query()->orderBy('nome')
            ->get(['id', 'nome']);

        return Inertia::render('Admin/Atribuicoes/Create', [
            'professores' => $professores,
            'turmas' => $turmas,
            'disciplinas' => $disciplinas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'professor_id' => 'required|exists:users,id',
            'turma_id' => 'required|exists:turmas,id',
            'disciplina_id' => 'required|exists:disciplinas,id',
        ]);

        // Verificar se a atribuição já existe
        $turma = $this->turmaService->query()->findOrFail($validated['turma_id']);

        $existe = DB::table('professor_turma')
            ->where('user_id', $validated['professor_id'])
            ->where('turma_id', $validated['turma_id'])
            ->where('disciplina_id', $validated['disciplina_id'])
            ->where('ano_letivo', $turma->ano_letivo)
            ->exists();

        if ($existe) {
            return redirect()->back()->withErrors([
                'error' => 'Esta atribuição já existe.'
            ]);
        }

        DB::table('professor_turma')->insert([
            'user_id' => $validated['professor_id'],
            'turma_id' => $validated['turma_id'],
            'disciplina_id' => $validated['disciplina_id'],
            'ano_letivo' => $turma->ano_letivo,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.atribuicoes.index')
            ->with('success', 'Atribuição criada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('professor_turma')->where('id', $id)->delete();

        return redirect()->route('admin.atribuicoes.index')
            ->with('success', 'Atribuição removida com sucesso!');
    }

    /**
     * Get atribuições de um professor
     */
    public function porProfessor(User $professor)
    {
        $atribuicoes = DB::table('professor_turma')
            ->join('turmas', 'professor_turma.turma_id', '=', 'turmas.id')
            ->join('disciplinas', 'professor_turma.disciplina_id', '=', 'disciplinas.id')
            ->where('professor_turma.user_id', $professor->id)
            ->select(
                'professor_turma.id',
                'turmas.nome as turma_nome',
                'turmas.turno as turma_turno',
                'turmas.ano_letivo',
                'disciplinas.nome as disciplina_nome'
            )
            ->orderBy('turmas.ano_letivo', 'desc')
            ->orderBy('turmas.nome')
            ->get();

        return response()->json($atribuicoes);
    }
}
