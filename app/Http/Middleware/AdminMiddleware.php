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
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('admin')) {
    // Pengguna memiliki peran 'admin'
    return $next($request);
}

// Pengguna tidak memiliki peran 'admin', lakukan sesuatu di sini
        return redirect('home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
    }
}
