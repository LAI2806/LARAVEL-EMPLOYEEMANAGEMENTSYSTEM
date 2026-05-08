<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckEmploymentStatus
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
        $user = Auth::user();

        if ($user->role === 'employee') {
            $employee = $user->employeeDetails;

            if ($employee && in_array($employee->employment_status, ['inactive', 'terminated'])) {
                if (!$request->routeIs('deactivated') && !$request->routeIs('logout')) {
                    return redirect()->route('deactivated');
                }
            }
        }
    }

    return $next($request);
}
}