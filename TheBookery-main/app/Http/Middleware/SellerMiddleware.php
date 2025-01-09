<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Check if the user is authenticated and has a "seller" role
        /* if (Auth::check() && Auth::user()->role === 'seller') {
            return $next($request);
        }*/
        if(auth()->user() && auth()->user()->role == 1) 
        {
            return $next($request);
        }
            return redirect('/403');

        // If not a seller, redirect or abort with an error
       // return redirect()->route('home')->withErrors(['access' => 'You do not have seller permissions to access this area.']);
    }
}
