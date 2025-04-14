<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use App\Models\Notification;
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

        // Xóa thông báo nhắc nhở đánh giá liên quan đến sản phẩm này (nếu có)
        Notification::where('user_id', $user->id)
            ->where('title', 'Nhắc nhở đánh giá sản phẩm')
            ->whereJsonContains('data->product_id', $productId)
            ->delete();

        // Lấy review mới nhất
        $reviews = Review::where('product_id', $productId)
        ->with('user')
        ->latest()
        ->get();

        // Tính toán số lượng đánh giá, điểm trung bình và phân phối đánh giá
        $ratingCount = $reviews->count();
        $averageRating = $reviews->avg('rating') ?? 0;
        $ratingDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingDistribution[$i] = $reviews->where('rating', $i)->count();
        }

        $hasReviewed = true;

        // Render HTML cho danh sách đánh giá
        $reviewsHtml = view('shop.reviews.partials.reviews_list', compact('reviews'))->render();

        // Render HTML cho phần điểm trung bình
        $averageRatingHtml = view('shop.reviews.partials.average_rating', compact('averageRating'))->render();

        // Render HTML cho phần phân phối sao
        $ratingListHtml = view('shop.reviews.partials.rating_list', compact('ratingCount', 'ratingDistribution'))->render();

        // Render HTML cho phần review-product
        $reviewProductHtml = view('shop.reviews.partials.review_product', compact('hasReviewed'))->render();

        return response()->json([
            'success' => 'Đánh giá của bạn đã được gửi!',
            'reviews_html' => $reviewsHtml,
            'average_rating_html' => $averageRatingHtml,
            'rating_list_html' => $ratingListHtml,
            'review_product_html' => $reviewProductHtml,
            'rating_count' => $ratingCount,
        ]);
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
