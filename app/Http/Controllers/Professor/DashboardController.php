<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $professor */
        $professor = $request->user();

        $anoAtual = date('Y');

        // Buscar turmas do professor no ano atual
        $turmas = $professor->turmas()
            ->wherePivot('ano_letivo', $anoAtual)
            ->where('ativa', true)
            ->withCount('alunos')
            ->orderBy('nome')
            ->get();

        // Buscar disciplinas do professor no ano atual (distintas)
        $disciplinas = $professor->disciplinas()
            ->wherePivot('ano_letivo', $anoAtual)
            ->orderBy('nome')
            ->get();

        return Inertia::render('Professor/Dashboard', [
            'turmas' => $turmas,
            'disciplinas' => $disciplinas,
        ]);
    }
}
