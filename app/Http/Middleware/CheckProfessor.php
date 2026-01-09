<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProfessor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Desenvolvedor tem acesso a tudo, coordenação e professor têm acesso às rotas de professor
        if (!$user || !in_array($user->role, ['professor', 'coordenacao', 'desenvolvedor'])) {
            abort(403, 'Acesso restrito a professores.');
        }

        return $next($request);
    }
}
