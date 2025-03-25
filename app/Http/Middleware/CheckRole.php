<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            if ($role === 'admin') {
                return redirect()->route('shop.home'); // Không phải admin, về shop
            } else {
                return redirect()->route('admin.login'); // Không phải user, về admin login
            }
        }
        return $next($request);
    }
}
