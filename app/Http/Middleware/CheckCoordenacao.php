<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCoordenacao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Desenvolvedor tem acesso a tudo, coordenação tem acesso às rotas admin
        if (!$user || !in_array($user->role, ['coordenacao', 'desenvolvedor'])) {
            abort(403, 'Acesso restrito à coordenação.');
        }

        return $next($request);
    }
}
