<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->paginate(10); // Lấy đơn hàng của user
        $categories = \App\Models\Category::whereNull('parent_id')->with(['children', 'products'])->get();

        // Đếm số thông báo chưa đọc (ví dụ: đơn hàng mới hoặc thay đổi trạng thái gần đây)
        $unreadCount = $user->orders()
            ->whereIn('status', ['pending', 'confirmed', 'processing']) // Tùy chỉnh trạng thái "chưa đọc"
            ->where('updated_at', '>', now()->subDays(7)) // Trong 7 ngày
            ->count();

        return view('shop.notifications', compact('orders', 'categories', 'unreadCount'));
    }
}
