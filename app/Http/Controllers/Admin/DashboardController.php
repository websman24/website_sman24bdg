<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display Admin Dashboard view.
     */
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'system_status' => 'Aktif & Optimal',
            'last_login' => auth()->user()->updated_at?->diffForHumans() ?? 'Baru saja',
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
