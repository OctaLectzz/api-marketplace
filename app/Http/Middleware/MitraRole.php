<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MitraRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || auth()->user()->role == 'Customer') {
            return response()->json([
                'status' => 'failed',
                'role' => auth()->check() ? auth()->user()->role : 'guest'
            ], 403);
        }

        return $next($request);
    }
}
