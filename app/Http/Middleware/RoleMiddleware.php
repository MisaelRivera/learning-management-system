<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()->role !== $role) {
            $dashboardUrl = '';
            switch ($request->user()->role) {
                case 'admin':
                    $dashboardUrl = 'admin.dashboard';
                break;
                case 'instructor':
                    $dashboardUrl = 'instructor.dashboard';
                break;
                case 'user':
                    $dashboardUrl = 'dashboard';
                break;
            }
            return redirect()
                ->route($dashboardUrl);
        }
        return $next($request);
    }
}
