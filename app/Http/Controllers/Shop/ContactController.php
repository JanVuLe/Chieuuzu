<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        Mail::to('vu_dth216249@student.agu.edu.vn')->send(new ContactMail($request->all()));

        return redirect()->back()->with('success', 'Tin nhắn của bạn đã được gửi!');
    }

    public function contactSupport(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string|max:500',
        ]);

        $product = Product::find($request->product_id);

        // Gửi email đến CSKH
        Mail::send('shop.emails.contact-support', [
            'product' => $product,
            'messageContent' => $request->message,
        ], function ($mail) {
            $mail->to('vu_dth216249@student.agu.edu.vn') // Email của CSKH
                ->subject('Yêu cầu hỗ trợ từ khách hàng');
        });

        return response()->json(['success' => true, 'message' => 'Yêu cầu hỗ trợ đã được gửi thành công!']);
    }
}
