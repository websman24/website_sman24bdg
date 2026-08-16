<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('admin.login');
        }

        $user = auth()->user();

        if (! $user->hasAnyRole($roles)) {
            Log::warning('Blocked unauthorized role access attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'required_roles' => $roles,
                'ip' => $request->ip(),
                'path' => $request->path(),
                'timestamp' => now()->toIso8601String(),
            ]);

            abort(403, 'Akses tidak diizinkan. Peran Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
