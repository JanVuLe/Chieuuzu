<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShopLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('shop.home');
        }
        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();
        return view('shop.auth.login', compact('categories'));
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'Hãy nhập email',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Hãy nhập mật khẩu',
            'password.min' => 'mật khẩu phải có ít nhất 8 ký tự'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('shop.home');
            }
        }

        Session::flash('error', 'Email hoặc mật khẩu không đúng');

        return redirect()->back()->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('shop.home')->with('success', 'Đã đăng xuất thành công');
    }
}
