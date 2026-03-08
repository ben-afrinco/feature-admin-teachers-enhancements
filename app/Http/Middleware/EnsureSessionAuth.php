<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class EnsureSessionAuth
 * 
 * A custom authentication guard that validates user sessions and roles.
 * Unlike Laravel's default 'auth' middleware which uses guards, this
 * specifically checks for 'user_id' in the session, catering to the 
 * project's custom registration/login flow.
 * 
 * @package App\Http\Middleware
 */
class EnsureSessionAuth
{
    /**
     * Handle an incoming request.
     * 
     * Verifies if the user is logged in (session has user_id) and if their
     * role matches the required roles for the route.
     * 
     * @param Request $request
     * @param Closure $next
     * @param string ...$roles Optional list of allowed roles (e.g., 'admin', 'teacher').
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $userId = session('user_id');
        $userRole = session('role');

        if (!$userId) {
            return redirect()->route('info_account')->with('error', 'الرجاء تسجيل الدخول أولاً.');
        }

        // If specific roles are required, check them
        if (!empty($roles) && !in_array($userRole, $roles)) {
            abort(403, 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
        }

        return $next($request);
    }
}

