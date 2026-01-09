<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Avaliacao;
use App\Models\AvaliacaoCriterio;
use App\Models\Criterio;
use App\Models\Disciplina;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class AvaliacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $anoAtual = date('Y');

        // Buscar turmas do professor no ano atual
        $turmas = $user->turmas()
            ->wherePivot('ano_letivo', $anoAtual)
            ->where('ativa', true)
            ->orderBy('nome')
            ->get();

        // Buscar disciplinas do professor no ano atual (distintas)
        $disciplinas = $user->disciplinas()
            ->wherePivot('ano_letivo', $anoAtual)
            ->orderBy('nome')
            ->get();

        return Inertia::render('Professor/Avaliacoes/Index', [
            'turmas' => $turmas,
            'disciplinas' => $disciplinas,
        ]);
    }

    /**
     * Listar alunos de uma turma para avaliação
     */
    public function listarAlunos(Turma $turma, Disciplina $disciplina, string $trimestre)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $anoAtual = date('Y');
        $temPermissao = DB::table('professor_turma')
            ->where('user_id', $user->id)
            ->where('turma_id', $turma->id)
            ->where('disciplina_id', $disciplina->id)
            ->where('ano_letivo', $anoAtual)
            ->exists();

        if (!$temPermissao) {
            abort(403, 'Você não tem permissão para avaliar esta turma/disciplina.');
        }

        $alunos = $turma->alunos()
            ->orderBy('numero_chamada')
            ->get()
            ->map(function ($aluno) use ($disciplina, $trimestre) {
                // Buscar avaliação existente
                $avaliacao = Avaliacao::where('aluno_id', $aluno->id)
                    ->where('disciplina_id', $disciplina->id)
                    ->where('trimestre', $trimestre)
                    ->first();

                $aluno->avaliacao_id = $avaliacao?->id;
                $aluno->nota_final = $avaliacao?->nota_final;
                return $aluno;
            });

        return Inertia::render('Professor/Avaliacoes/ListarAlunos', [
            'turma' => $turma,
            'disciplina' => $disciplina,
            'trimestre' => $trimestre,
            'alunos' => $alunos,
        ]);
    }

    /**
     * Avaliar aluno individualmente
     */
    public function avaliar(Aluno $aluno, Disciplina $disciplina, string $trimestre)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verificar permissão
        if (!$user->disciplinas->contains($disciplina)) {
            abort(403, 'Você não tem permissão para avaliar esta disciplina.');
        }

        $aluno->load('turma');
        $criterios = Criterio::orderBy('ordem')->get();

        // Buscar avaliação existente
        $avaliacao = Avaliacao::where('aluno_id', $aluno->id)
            ->where('disciplina_id', $disciplina->id)
            ->where('trimestre', $trimestre)
            ->first();

        $valoresCriterios = [];
        if ($avaliacao) {
            $valoresCriterios = AvaliacaoCriterio::where('avaliacao_id', $avaliacao->id)
                ->pluck('valor', 'criterio_id')
                ->toArray();
        }

        // Buscar aluno anterior e próximo
        $alunosIds = $aluno->turma->alunos()->orderBy('numero_chamada')->pluck('id');
        $currentIndex = $alunosIds->search($aluno->id);

        $alunoAnterior = $currentIndex > 0 ? Aluno::find($alunosIds[$currentIndex - 1]) : null;
        $proximoAluno = $currentIndex < $alunosIds->count() - 1 ? Aluno::find($alunosIds[$currentIndex + 1]) : null;

        return Inertia::render('Professor/Avaliacoes/Avaliar', [
            'aluno' => $aluno,
            'disciplina' => $disciplina,
            'trimestre' => $trimestre,
            'criterios' => $criterios,
            'avaliacao' => $avaliacao,
            'valoresCriterios' => $valoresCriterios,
            'alunoAnterior' => $alunoAnterior,
            'proximoAluno' => $proximoAluno,
        ]);
    }

    /**
     * Store or update avaliação
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'disciplina_id' => 'required|exists:disciplinas,id',
            'trimestre' => 'required|in:1,2,3',
            'criterios' => 'required|array',
            'criterios.*' => 'required|numeric|min:0|max:4',
            'observacoes' => 'nullable|string|max:1000',
        ]);

        // Buscar aluno para obter turma_id
        $aluno = Aluno::findOrFail($validated['aluno_id']);

        // Verificar permissão
        if (!$user->disciplinas->contains($validated['disciplina_id'])) {
            abort(403, 'Você não tem permissão para avaliar esta disciplina.');
        }

        DB::beginTransaction();
        try {
            // Buscar ou criar avaliação
            $avaliacao = Avaliacao::updateOrCreate(
                [
                    'aluno_id' => $validated['aluno_id'],
                    'disciplina_id' => $validated['disciplina_id'],
                    'trimestre' => $validated['trimestre'],
                ],
                [
                    'turma_id' => $aluno->turma_id,
                    'professor_id' => $user->id,
                    'ano_letivo' => date('Y'),
                    'observacoes' => $validated['observacoes'] ?? null,
                ]
            );

            // Salvar critérios e calcular nota
            $somaPonderada = 0;
            $somaPesos = 0;

            foreach ($validated['criterios'] as $criterioId => $valor) {
                $criterio = Criterio::find($criterioId);

                AvaliacaoCriterio::updateOrCreate(
                    [
                        'avaliacao_id' => $avaliacao->id,
                        'criterio_id' => $criterioId,
                    ],
                    [
                        'valor' => $valor,
                    ]
                );

                // Fórmula: (valor/4 * peso)
                $somaPonderada += ($valor / 4) * $criterio->peso;
                $somaPesos += $criterio->peso;
            }

            // Nota final: (soma ponderada / soma pesos) * 10
            $notaFinal = ($somaPonderada / $somaPesos) * 10;
            $avaliacao->nota_final = round($notaFinal, 2);
            $avaliacao->save();

            DB::commit();

            return redirect()->back()->with('success', 'Avaliação salva com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Erro ao salvar avaliação: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Avaliacao $avaliacao)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Verificar se o professor pode excluir esta avaliação
        if ($avaliacao->professor_id !== $user->id && !$user->isCoordenacao()) {
            abort(403, 'Você não tem permissão para excluir esta avaliação.');
        }

        $avaliacao->delete();

        return redirect()->back()->with('success', 'Avaliação excluída com sucesso!');
    }
}
