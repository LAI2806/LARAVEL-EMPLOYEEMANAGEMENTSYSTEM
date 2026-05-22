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

        if (!Auth::check()) {
            return redirect('/login');
        }

        $allowedRoles = [];
        foreach ($roles as $role) {
            $parts = explode(',', $role); 
            $parts = array_map(fn($r) => strtolower(trim($r)), $parts); 
            $allowedRoles = array_merge($allowedRoles, $parts);
        }

        $userRole = strtolower(trim(Auth::user()->role));

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}