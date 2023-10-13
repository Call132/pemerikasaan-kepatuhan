<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && auth()->user()->hasRoles('admin')) {

            return redirect()->route('admin.dashboard');
        } elseif (auth()->check() && auth()->user()->hasRoles('user')) {

            return redirect()->route('/');



            return $next($request);
        }
    }
}
