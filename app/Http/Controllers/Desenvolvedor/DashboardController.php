<?php

namespace App\Http\Controllers\Desenvolvedor;

use App\Http\Controllers\Controller;
use App\Domains\Usuarios\Services\UserService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index()
    {
        $stats = [
            'total_desenvolvedores' => $this->userService->query()->desenvolvedor()->count(),
            'total_coordenadores' => $this->userService->query()->coordenacao()->count(),
            'total_professores' => $this->userService->query()->professores()->count(),
            'total_usuarios' => $this->userService->count(),
        ];

        return Inertia::render('Desenvolvedor/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
