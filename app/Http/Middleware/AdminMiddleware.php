<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!Auth::check() || !($user instanceof \App\Models\User) || !$user->isAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
