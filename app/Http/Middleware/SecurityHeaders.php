<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class SecurityHeaders
 * 
 * Global middleware that enriches every HTTP response with security-hardened
 * headers to protect against common web vulnerabilities like XSS, 
 * clickjacking, and MIME-sniffing.
 * 
 * @package App\Http\Middleware
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request and set security headers on the response.
     * 
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Prevent MIME type sniffing - forcing browser to respect Content-Type
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Prevent clickjacking - preventing the app from being embedded in iframes elsewhere
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // XSS Protection (legacy browsers) - enables the XSS filter built into older browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer policy - controls how much referrer information is included with requests
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions policy - restricts access to hardware APIs like camera and mic
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(self), geolocation=()');

        return $response;
    }
}

