<?php

namespace App\Http\Controllers\Desenvolvedor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_desenvolvedores' => User::desenvolvedor()->count(),
            'total_coordenadores' => User::coordenacao()->count(),
            'total_professores' => User::professores()->count(),
            'total_usuarios' => User::count(),
        ];

        return Inertia::render('Desenvolvedor/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
