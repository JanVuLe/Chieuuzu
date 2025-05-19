<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Lấy danh mục cha và các danh mục con, sản phẩm (nếu cần cho sidebar/header)
        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        // Lấy tất cả đơn hàng của user, kèm chi tiết sản phẩm
        $orders = Order::where('user_id', $user->id)
            ->with(['orderDetails.product'])
            ->latest()
            ->paginate(10);

        return view('shop.notifications', compact('orders', 'categories'));
    }
}