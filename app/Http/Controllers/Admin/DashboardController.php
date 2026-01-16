<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domains\Alunos\Services\AlunoService;
use App\Domains\Alunos\Services\TurmaService;
use App\Domains\Avaliacoes\Services\AvaliacaoService;
use App\Domains\Usuarios\Services\UserService;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(
        private readonly AlunoService $alunoService,
        private readonly TurmaService $turmaService,
        private readonly UserService $userService,
        private readonly AvaliacaoService $avaliacaoService
    ) {}

    public function index()
    {
        $stats = [
            'total_alunos' => $this->alunoService->query()->count(),
            'total_turmas' => $this->turmaService->query()->anoAtual()->count(),
            'total_professores' => $this->userService->query()->professores()->count(),
            'total_avaliacoes' => $this->avaliacaoService->query()->whereYear('created_at', date('Y'))->count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
