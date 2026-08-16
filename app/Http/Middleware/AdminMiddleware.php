<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request for Admin routes.
     *
     * Checks:
     * 1. User is authenticated
     * 2. User has admin/superadmin role
     * 3. User account is still active (catches accounts deactivated mid-session)
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check authentication
        if (! auth()->check()) {
            return redirect()->route('admin.login')
                ->with('warning', 'Silakan masuk terlebih dahulu untuk mengakses portal admin.');
        }

        $user = auth()->user();

        // Check if account is still active — catches accounts deactivated mid-session
        if (! $user->is_active) {
            Log::warning('Blocked admin access: account was deactivated mid-session', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'path' => $request->path(),
                'timestamp' => now()->toIso8601String(),
            ]);

            // Force logout the deactivated account
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Hubungi administrator sistem.');
        }

        // Validating role: any valid role can access the admin panel generally,
        // specific route access is controlled by RoleMiddleware on the routes.
        if (! in_array($user->role, ['superadmin', 'admin', 'editor', 'guru'], true)) {
            Log::warning('Blocked unauthorized admin access attempt', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip(),
                'path' => $request->path(),
                'timestamp' => now()->toIso8601String(),
            ]);

            abort(403, 'Akses tidak diizinkan. Peran Anda tidak valid untuk portal ini.');
        }

        return $next($request);
    }
}
