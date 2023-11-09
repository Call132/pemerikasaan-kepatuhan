<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStoreSptCall
{
    private $called = false;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->called) {
            $this->called = true;
            return $next($request);
        }

        // Jika storeSpt sudah dipanggil sebelumnya, kembalikan respons yang sesuai.
        return response()->json(['error' => 'Metode storeSpt sudah dipanggil.'], 400);
    }
}
