<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Please authenticate as admin first');
        }

        return $next($request);
    }
}
