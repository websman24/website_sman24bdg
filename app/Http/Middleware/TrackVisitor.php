<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Rate limit window in seconds.
     * One unique IP+URL combination is tracked at most once per this period.
     */
    private const RATE_WINDOW_SECONDS = 300; // 5 minutes

    /**
     * Handle an incoming request.
     *
     * Security: cache-based rate limiting prevents a single IP from flooding
     * the visitor_logs table via repeated requests (DoS/database exhaustion).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track successful GET requests on public pages
        if (
            $request->isMethod('GET') &&
            ! $request->is('admin*') &&
            ! $request->is('api*') &&
            ! $request->is('up') &&
            ! $request->is('storage*') &&
            ! $request->is('livewire*') &&
            ! $request->ajax()
        ) {
            try {
                $ip = $request->ip() ?? '127.0.0.1';
                $path = substr($request->path(), 0, 250);
                $today = now()->toDateString();

                // Rate-limit: allow tracking at most once per IP per URL per RATE_WINDOW_SECONDS
                // Uses a short MD5 key to keep cache keys compact
                $cacheKey = 'visitor:' . md5($ip . '|' . $path);

                if (! Cache::has($cacheKey)) {
                    Cache::put($cacheKey, 1, self::RATE_WINDOW_SECONDS);

                    VisitorLog::create([
                        'ip_address' => $ip,
                        'page_url'   => $path,
                        'user_agent' => substr((string) $request->userAgent(), 0, 250),
                        'visit_date' => $today,
                    ]);
                }
            } catch (\Throwable $e) {
                // Silently ignore tracking errors so public page rendering is never affected
            }
        }

        return $response;
    }
}
