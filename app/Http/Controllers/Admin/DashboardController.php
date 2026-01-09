<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Avaliacao;
use App\Models\Turma;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_alunos' => Aluno::active()->count(),
            'total_turmas' => Turma::active()->anoAtual()->count(),
            'total_professores' => User::professores()->active()->count(),
            'total_avaliacoes' => Avaliacao::whereYear('created_at', date('Y'))->count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
