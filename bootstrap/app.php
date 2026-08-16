<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SecurityHeadersMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'auth', AdminMiddleware::class, 'throttle:120,1'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Redirect unauthenticated users to admin login page
        $middleware->redirectTo(
            guests: '/admin/login',
        );

        // Register named middleware aliases
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'role'  => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Exclude logout routes from strict CSRF token validation to prevent 419 on session expiry
        $middleware->validateCsrfTokens(except: [
            'admin/logout',
            'logout',
        ]);

        // Apply security headers to all web responses globally
        $middleware->web(append: [
            SecurityHeadersMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 419 Page Expired (CSRF Token Mismatch) — redirect to login with notification
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sesi Anda telah berakhir. Silakan masuk kembali.'], 419);
            }

            return redirect()->route('admin.login')
                ->with('warning', 'Sesi Anda telah berakhir. Silakan masuk kembali.');
        });

        // Handle 404 Not Found — show branded error page instead of default
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Resource not found.'], 404);
            }

            return response()->view('errors.404', [], 404);
        });

        // Handle 403 Access Denied — show branded error page
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Access denied.'], 403);
            }

            return response()->view('errors.403', [], 403);
        });

        // In production: hide all technical error details from end users
        if (app()->environment('production')) {
            $exceptions->render(function (\Throwable $e, Request $request) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'An unexpected error occurred. Please try again later.',
                    ], 500);
                }

                // Log the real error for developer review, but show generic page to user
                if (! ($e instanceof NotFoundHttpException) && ! ($e instanceof AccessDeniedHttpException)) {
                    return response()->view('errors.500', [], 500);
                }
            });
        }
    })->create();
