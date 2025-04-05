<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        // Lấy thông báo từ bảng notifications
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        // Đếm số thông báo chưa đọc
        $unreadCount = $notifications->where('is_read', false)->count();

        // Lấy các sản phẩm từ đơn hàng "delivered" chưa được đánh giá
        $reviewableProducts = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->with(['orderDetails.product' => function ($query) use ($user) {
                $query->whereDoesntHave('reviews', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            }])
            ->get()
            ->pluck('orderDetails')
            ->flatten()
            ->pluck('product')
            ->filter();

        // Tạo thông báo nhắc nhở đánh giá nếu chưa có
        foreach ($reviewableProducts as $product) {
            $existingNotification = Notification::where('user_id', $user->id)
                ->where('title', 'Nhắc nhở đánh giá sản phẩm')
                ->whereJsonContains('data->product_id', $product->id)
                ->exists();

            if (!$existingNotification) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Nhắc nhở đánh giá sản phẩm',
                    'message' => "Bạn có sản phẩm {$product->name} đã nhận nhưng chưa đánh giá.",
                    'data' => ['product_id' => $product->id],
                ]);
            }
        }

        return view('shop.notifications', compact('notifications', 'categories', 'unreadCount', 'reviewableProducts'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        // Kiểm tra xem thông báo có liên quan đến đơn hàng không
        if (isset($notification->data['order_id'])) {
            return redirect()->route('shop.order.show', $notification->data['order_id']);
        }

        // Nếu không có order_id, quay lại trang thông báo
        return redirect()->route('shop.notifications');
    }
}