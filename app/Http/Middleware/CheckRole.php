<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next, $role): Response
    {
    //     dd([
    //     'user_role' => auth()->user()->role,
    //     'required_role' => $role,
    // ]);
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role != $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
