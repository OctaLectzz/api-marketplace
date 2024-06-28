<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::findOrFail(auth()->id());

        if ($user->role !== 'Admin') {
            return response()->json([
                'status' => 'failed',
                'role' => auth()->check() ? auth()->user()->role : 'guest'
            ], 403);
        }
        
        return $next($request);
    }
}
