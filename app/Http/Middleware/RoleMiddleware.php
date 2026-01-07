<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Accepts a comma-separated list of roles; user must have one of them.
     */
    public function handle(Request $request, Closure $next, $roles = null)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if ($roles) {
            $allowed = array_map('trim', explode(',', $roles));
            $userRole = auth()->user()->role ?? null;
            if (!in_array($userRole, $allowed, true)) {
                abort(403, 'Unauthorized');
            }
        }

        return $next($request);
    }
}
