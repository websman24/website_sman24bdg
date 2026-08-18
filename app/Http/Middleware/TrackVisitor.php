<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests on public pages
        if (
            $request->isMethod('GET') &&
            !$request->is('admin*') &&
            !$request->is('api*') &&
            !$request->is('up') &&
            !$request->is('storage*') &&
            !$request->is('livewire*') &&
            !$request->ajax()
        ) {
            try {
                $ip = $request->ip() ?? '127.0.0.1';
                $today = now()->toDateString();

                // Rate-limit tracking: avoid duplicate log from same IP on same URL within same minute
                VisitorLog::create([
                    'ip_address' => $ip,
                    'page_url' => substr($request->path(), 0, 250),
                    'user_agent' => substr((string) $request->userAgent(), 0, 250),
                    'visit_date' => $today,
                ]);
            } catch (\Throwable $e) {
                // Silently ignore tracking errors so public page rendering is never affected
            }
        }

        return $response;
    }
}
