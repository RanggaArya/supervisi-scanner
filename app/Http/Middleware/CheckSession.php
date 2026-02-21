<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user_id')) {
            // Redirect ke home jika belum login
            return redirect()->route('home')
                ->with('error', 'Silakan login terlebih dahulu');
        }
        return $next($request);
    }
}
