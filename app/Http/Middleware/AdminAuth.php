<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('admin_auth')) {
            // The consultations page shows the login form when not signed in
            return redirect()->route('admin.consultations');
        }

        return $next($request);
    }
}
