<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Notification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        Notification::create([
            'user_id' => $order->user_id,
            'title' => "Đơn hàng #{$order->id} - Đang chờ xác nhận",
            'message' => "Đơn hàng #{$order->id} của bạn đang chờ xác nhận. Cảm ơn bạn đã đặt hàng!",
            'data' => ['order_id' => $order->id],
        ]);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            $message = match ($order->status) {
                'confirmed' => "Đơn hàng #{$order->id} đã được xác nhận.",
                'processing' => "Đơn hàng #{$order->id} đang được xử lý.",
                'shipped' => "Đơn hàng #{$order->id} đã được giao đi.",
                'delivered' => "Đơn hàng #{$order->id} đã giao thành công.",
                'cancelled' => "Đơn hàng #{$order->id} đã bị hủy.",
                default => "Đơn hàng #{$order->id} có trạng thái: {$order->status}",
            };

            // Lấy danh sách sản phẩm trong đơn hàng
            $productIds = $order->orderDetails->pluck('product_id')->toArray();

            Notification::create([
                'user_id' => $order->user_id,
                'title' => "Đơn hàng #{$order->id} - " . ucfirst($order->status),
                'message' => $message,
                'data' => [
                    'order_id' => $order->id,
                    'product_ids' => $productIds,
                ],
            ]);
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
