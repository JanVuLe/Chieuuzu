<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->to('/admin/login')->with('error', 'Bạn cần đăng nhập trước.');
        }

        $user = Auth::user();

        if ($user->role !== 'admin') {
            return redirect()->route('shop.home')->with('error', 'Bạn không có quyền truy cập khu vực quản trị.');
        }

        if (!$user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->to('/admin/login')->with('error', 'Tài khoản của bạn đã bị vô hiệu hóa.');
        }

        return $next($request);
    }
}
