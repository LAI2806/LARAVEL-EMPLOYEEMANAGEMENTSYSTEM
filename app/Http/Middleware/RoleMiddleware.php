<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Flatten comma-separated roles and normalize
        $allowedRoles = [];
        foreach ($roles as $role) {
            $parts = explode(',', $role);               // split comma-separated string
            $parts = array_map(fn($r) => strtolower(trim($r)), $parts); // trim + lowercase
            $allowedRoles = array_merge($allowedRoles, $parts);
        }

        // Get current user's role (trim + lowercase)
        $userRole = strtolower(trim(Auth::user()->role));

        // Abort if user role not in allowed roles
        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        // Allow request to proceed
        return $next($request);
    }
}