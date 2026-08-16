<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    /**
     * Display login form view.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle authentication login submission.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        $result = $this->authService->attemptLogin($credentials, $remember);

        // Account is inactive — show specific but non-revealing error
        if ($result === 'inactive') {
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator sistem.',
            ])->onlyInput('email');
        }

        // Credentials did not match
        if ($result === false) {
            return back()->withErrors([
                'email' => 'Kombinasi email dan kata sandi tidak cocok.',
            ])->onlyInput('email');
        }

        // Success — regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Selamat datang kembali, '.auth()->user()->name.'!');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logoutUser($request);

        return redirect()->route('admin.login')
            ->with('info', 'Anda telah keluar dari sistem.');
    }
}
