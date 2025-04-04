<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['images', 'category', 'discounts'])->firstOrFail();

        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->with(['images', 'discounts'])->take(6)->get();

        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => 'Chi tiết sản phẩm', 'url' => ''],
        ];

        // Kiểm tra xem người dùng đã mua sản phẩm và đơn hàng đã xác nhận/giao chưa
        $hasPurchased = Auth::check() ? Order::where('user_id', Auth::id())
            ->whereIn('status', ['confirmed', 'delivered'])
            ->whereHas('orderDetails', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists() : false;

        // Kiểm tra xem người dùng đã đánh giá sản phẩm chưa
        $hasReviewed = Auth::check() ? Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists() : false;
        
        // Tính số lượng đánh giá
        $ratingCount = $product->reviews->count();
        $averageRating = $product->averageRating() ?? 0; // Nếu không có đánh giá, trả về 0
        
        return view('shop.product-detail', compact('product', 'categories', 'relatedProducts', 'breadcrumbs', 'hasPurchased', 'hasReviewed', 'ratingCount', 'averageRating'));
    }
}
