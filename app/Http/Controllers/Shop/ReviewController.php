<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $productId = $request->product_id;

        // Kiểm tra xem người dùng đã mua sản phẩm và đơn hàng đã được xác nhận hoặc giao
        $hasPurchased = Order::where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'delivered'])
            ->whereHas('orderDetails', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm sau khi mua và đơn hàng được xác nhận hoặc giao!');
        }

        // Kiểm tra xem người dùng đã đánh giá sản phẩm này chưa
        if (Review::where('user_id', $user->id)->where('product_id', $productId)->exists()) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        Review::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }

    public function show($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->with('user')
            ->latest()
            ->get();

        return view('shop.reviews.show', compact('reviews'));
    }
}
