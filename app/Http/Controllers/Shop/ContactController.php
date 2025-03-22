<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => 'Liên hệ', 'url' => route('shop.contact')],
        ];

        return view('shop.contact', compact('categories', 'breadcrumbs'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Logic gửi email hoặc lưu tin nhắn vào database
        // Ví dụ: Gửi email
        // \Mail::to('tanchaulongap@gmail.com')->send(new \App\Mail\ContactMail($request->all()));

        return redirect()->back()->with('success', 'Tin nhắn của bạn đã được gửi!');
    }
}
