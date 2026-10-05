<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <--- A MÁGICA QUE FALTAVA AQUI!

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Se o usuário não estiver logado ou o cargo dele não for o exigido, barra o acesso
        if (!Auth::check() || Auth::user()->role !== $role) {

            // Redireciona para o lugar seguro de acordo com quem ele é
            if (Auth::check() && Auth::user()->role === 'atleta') {
                return redirect('/app');
            }
            if (Auth::check() && Auth::user()->role === 'treinador') {
                return redirect('/treinador');
            }

            return redirect('/login')->with('error', 'Acesso negado.');
        }

        return $next($request);
    }
}
