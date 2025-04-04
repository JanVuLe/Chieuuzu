<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10);
        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        // Đếm số thông báo chưa đọc
        $unreadCount = $user->orders()
            ->whereIn('status', ['pending', 'confirmed', 'processing'])
            ->where('updated_at', '>', now()->subDays(7))
            ->count();

        // Lấy các sản phẩm từ đơn hàng "delivered" chưa được đánh giá
        $reviewableProducts = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->with(['orderDetails.product' => function ($query) use ($user) {
                $query->whereDoesntHave('reviews', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }])
            ->get()
            ->pluck('details')
            ->flatten()
            ->pluck('product')
            ->filter();

        return view('shop.notifications', compact('orders', 'categories', 'unreadCount', 'reviewableProducts'));
    }
}
