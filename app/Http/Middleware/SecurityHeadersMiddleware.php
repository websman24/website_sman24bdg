<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Security Headers Middleware
 *
 * Adds HTTP security headers to all responses to protect against common
 * web vulnerabilities: XSS, clickjacking, MIME sniffing, and data injection.
 */
class SecurityHeadersMiddleware
{
    /**
     * List of domains allowed in CSP for external resources.
     * Update these if you add third-party services.
     */
    private const TRUSTED_FONTS = [
        'https://fonts.googleapis.com',
        'https://fonts.gstatic.com',
    ];

    private const TRUSTED_SCRIPTS = [
        'https://www.google.com',
        'https://www.gstatic.com',
        'https://maps.googleapis.com',
        'https://maps.gstatic.com',
    ];

    private const TRUSTED_FRAMES = [
        'https://www.google.com',
        'https://www.youtube.com',
        'https://www.youtube-nocookie.com',
        'https://maps.google.com',
        'https://www.google.com/maps',
    ];

    /**
     * Handle an incoming request and append security headers.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Skip binary / file download responses
        if ($this->isBinaryResponse($response)) {
            return $response;
        }

        $this->applySecurityHeaders($response, $request);

        return $response;
    }

    /**
     * Apply all security headers to the response.
     */
    private function applySecurityHeaders(Response $response, Request $request): void
    {
        // 1. Content-Security-Policy
        // Skip CSP in local development to avoid breaking Vite HMR and inline styles
        if (!app()->environment('local')) {
            $response->headers->set('Content-Security-Policy', $this->buildCsp());
        }

        // 2. X-Frame-Options — prevent clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 3. X-Content-Type-Options — prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 4. Referrer-Policy — control referrer information
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. Permissions-Policy — disable dangerous browser features
        $response->headers->set('Permissions-Policy', $this->buildPermissionsPolicy());

        // 6. X-XSS-Protection — legacy XSS filter for older browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 7. Strict-Transport-Security (HSTS) — HTTPS only, in production
        if ($request->isSecure() || app()->environment('production')) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        // 8. Remove server information headers that expose internals
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');
    }

    /**
     * Build the Content-Security-Policy header value.
     */
    private function buildCsp(): string
    {
        $fontSources = implode(' ', self::TRUSTED_FONTS);
        $scriptSources = implode(' ', self::TRUSTED_SCRIPTS);
        $frameSources = implode(' ', self::TRUSTED_FRAMES);

        $connectSrc = "connect-src 'self'";
        if (!app()->environment('production')) {
            // Allow Vite HMR in local development
            $scriptSources .= " http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173";
            $styleSources = $fontSources . " http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173";
            $connectSrc .= " ws://localhost:5173 ws://127.0.0.1:5173 ws://[::1]:5173 wss:";
        } else {
            $styleSources = $fontSources;
        }

        $directives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' {$scriptSources}",
            "style-src 'self' 'unsafe-inline' {$styleSources}",
            "font-src 'self' {$fontSources}",
            "img-src 'self' data: blob: https:",
            "media-src 'self' https://www.youtube.com https://www.youtube-nocookie.com",
            "frame-src 'self' {$frameSources}",
            $connectSrc,
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ];

        if (app()->environment('production')) {
            $directives[] = "upgrade-insecure-requests";
        }

        return implode('; ', $directives);
    }

    /**
     * Build the Permissions-Policy header value.
     */
    private function buildPermissionsPolicy(): string
    {
        return implode(', ', [
            'camera=()',
            'microphone=()',
            'geolocation=(self)',
            'payment=()',
            'usb=()',
            'fullscreen=(self)',
            'display-capture=()',
            'interest-cohort=()',
        ]);
    }

    /**
     * Determine if the response is a binary / file download response.
     * We skip adding HTML headers to binary responses.
     */
    private function isBinaryResponse(Response $response): bool
    {
        $contentType = $response->headers->get('Content-Type', '');

        $binaryTypes = [
            'application/pdf',
            'application/zip',
            'application/octet-stream',
            'image/',
            'video/',
            'audio/',
        ];

        foreach ($binaryTypes as $type) {
            if (str_contains($contentType, $type)) {
                return true;
            }
        }

        return false;
    }
}
