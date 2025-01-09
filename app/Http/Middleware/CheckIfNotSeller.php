<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIfNotSeller
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === '1') {
            return redirect()->route('front.home')->with('error', 'Sellers cannot access the checkout page.');
        }

        return $next($request);
    }
}
