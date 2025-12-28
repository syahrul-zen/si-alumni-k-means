<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class AdminPimpinan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::guard('admin_pimpinan')->check() && !Auth::guard('alumni')->check()) {
            return redirect("/login");
        }

        if (Auth::guard('alumni')->check()) {
            return redirect("/dashboard-alumni");
        }

        return $next($request);
    }
}
