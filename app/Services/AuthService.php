<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Attempt user login with security checks.
     *
     * Checks:
     * 1. Credentials validity via Auth::attempt()
     * 2. Account active status (is_active flag)
     * 3. Logs all login attempts (success and failure) for audit trail
     *
     * @param  array<string, string>  $credentials
     */
    public function attemptLogin(array $credentials, bool $remember = false): bool|string
    {
        $email = $credentials['email'];

        // Attempt authentication against the database
        if (! Auth::attempt([
            'email' => $email,
            'password' => $credentials['password'],
        ], $remember)) {
            // Log failed login attempt for security monitoring
            Log::warning('Admin login failed: invalid credentials', [
                'email' => $email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'timestamp' => now()->toIso8601String(),
            ]);

            return false;
        }

        // Check if the authenticated account is still active
        $user = Auth::user();

        if (! $user->is_active) {
            // Log out immediately — inactive accounts must not maintain sessions
            Auth::logout();

            Log::warning('Admin login rejected: account is inactive', [
                'email' => $email,
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'timestamp' => now()->toIso8601String(),
            ]);

            // Return special string so controller can show specific error message
            return 'inactive';
        }

        // Log successful login for audit trail
        Log::info('Admin login successful', [
            'user_id' => $user->id,
            'email' => $email,
            'role' => $user->role,
            'ip' => request()->ip(),
            'timestamp' => now()->toIso8601String(),
        ]);

        return true;
    }

    /**
     * Logout user and fully invalidate session.
     */
    public function logoutUser(Request $request): void
    {
        $user = Auth::user();

        if ($user) {
            Log::info('Admin logout', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'timestamp' => now()->toIso8601String(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
