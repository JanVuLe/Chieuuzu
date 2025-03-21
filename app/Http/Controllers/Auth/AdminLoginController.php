<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login', [
            'title' => 'Đăng nhập'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Hãy nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Hãy nhập mật khẩu',
            'password.min' => 'mật khẩu phải có ít nhất 8 ký tự'
        ]);

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {
            $user = Auth::user();

            if ($user->role === 'admin' && $user->is_active) {
                return redirect()->route('admin');
            }

            Auth::logout();
            Session::flash('error', 'Chỉ tài khoản admin đã kích hoạt mới có thể đăng nhập!');
            return redirect()->back();
        }

        Session::flash('error', 'Email hoặc mật khẩu không đúng');
        return redirect()->back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Đã đăng xuất thành công');
    }
}
