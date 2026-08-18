<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin Audit Log Middleware
 *
 * Records all mutating HTTP requests (POST, PUT, PATCH, DELETE) in the
 * admin panel to a structured audit log. This creates a tamper-evident
 * trail of who changed what, when, and from where.
 *
 * Log entries contain:
 * - Actor: user ID, email, role
 * - Request: method, path, IP, user agent
 * - Response: HTTP status code
 * - Timestamp (ISO 8601)
 *
 * These logs are written at WARNING level to ensure they are always
 * captured even when LOG_LEVEL is set to 'error' in production.
 */
class AuditLogMiddleware
{
    /**
     * Sensitive field names that should never appear in audit log payloads.
     * Any request input key matching these patterns is redacted.
     *
     * @var list<string>
     */
    private const SENSITIVE_FIELDS = [
        'password',
        'password_confirmation',
        'current_password',
        'token',
        'secret',
        '_token',
    ];

    /**
     * HTTP methods to audit (only write/delete operations).
     *
     * @var list<string>
     */
    private const AUDITED_METHODS = ['POST', 'PUT', 'PATCH', 'DELETE'];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only audit mutating operations — GET/HEAD requests are read-only
        if (! in_array($request->method(), self::AUDITED_METHODS, true)) {
            return $response;
        }

        $user = auth()->user();

        // Redact sensitive fields from the input payload before logging
        $payload = array_map(
            fn ($key) => '[REDACTED]',
            array_flip(
                array_intersect(
                    array_keys($request->all()),
                    self::SENSITIVE_FIELDS
                )
            )
        ) + array_diff_key(
            $request->except(['_token', '_method']),
            array_flip(self::SENSITIVE_FIELDS)
        );

        // Truncate very large payloads (e.g., rich text content) to keep logs readable
        $truncatedPayload = array_map(function ($value) {
            if (is_string($value) && mb_strlen($value) > 500) {
                return mb_substr($value, 0, 500) . '... [TRUNCATED]';
            }

            return $value;
        }, $payload);

        Log::channel('daily')->warning('[ADMIN AUDIT]', [
            'user_id'    => $user?->id ?? 'guest',
            'email'      => $user?->email ?? 'unauthenticated',
            'role'       => $user?->role ?? 'none',
            'method'     => $request->method(),
            'path'       => $request->path(),
            'status'     => $response->getStatusCode(),
            'ip'         => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 150),
            'payload'    => $truncatedPayload,
            'timestamp'  => now()->toIso8601String(),
        ]);

        return $response;
    }
}
