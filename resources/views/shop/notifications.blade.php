@extends('shop.layouts.master')
@section('title', 'Thông báo đơn hàng')
@section('content')
<div class="notifications-container">
    <h1 class="text-center mb-4">Thông báo đơn hàng</h1>

    @if ($orders->isEmpty())
        <p class="text-center">Bạn chưa có đơn hàng nào.</p>
    @else
        @foreach ($orders as $order)
            <div class="notification-item {{ in_array($order->status, ['pending', 'confirmed', 'processing']) && $order->updated_at > now()->subDays(7) ? 'unread' : '' }}">
                <div class="title">
                    <a href="{{ route('shop.order.show', $order->id) }}" class="text-decoration-underline text-primary">
                        Đơn hàng #{{ $order->id }} - {{ ucfirst($order->status) }}
                    </a>
                </div>
                <div class="message">
                    @switch($order->status)
                        @case('pending')
                            Đơn hàng của bạn đang chờ xác nhận.
                            @break
                        @case('confirmed')
                            Đơn hàng đã được xác nhận.
                            @break
                        @case('processing')
                            Đơn hàng đang được xử lý.
                            @break
                        @case('shipped')
                            Đơn hàng đã được giao đi.
                            @break
                        @case('delivered')
                            @php
                                // Lấy danh sách sản phẩm chưa được đánh giá từ đơn hàng
                                $unreviewedProducts = $order->orderDetails()
                                    ->whereDoesntHave('product.reviews', function ($query) use ($order) {
                                        $query->where('user_id', $order->user_id);
                                    })
                                    ->with('product')
                                    ->get()
                                    ->pluck('product')
                                    ->filter();
                            @endphp
                            Đơn hàng đã giao thành công.
                            @if($unreviewedProducts->isNotEmpty())
                                <br>
                                <strong>Nhắc nhở:</strong> Bạn có thể đánh giá sản phẩm:
                                <ul>
                                    @foreach($unreviewedProducts as $product)
                                        <li>
                                            <a href="{{ route('shop.product', ['slug' => $product->slug, 'review' => 'open']) }}">
                                                {{ $product->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            @break
                        @case('cancelled')
                            Đơn hàng đã bị hủy.
                            @break
                        @default
                            Trạng thái đơn hàng: {{ $order->status }}
                    @endswitch
                    Tổng tiền: {{ number_format($order->total_price) }} VNĐ
                </div>
                <div class="time">{{ $order->updated_at->diffForHumans() }}</div>
            </div>
        @endforeach

        <div class="mt-4">
            {{ $orders->links() }} <!-- Phân trang -->
        </div>
    @endif
</div>
@push('styles')
<style>
    .notifications-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .notification-item {
        padding: 15px;
        border-bottom: 1px solid #e7eaec;
    }

    .notification-item.unread {
        background: #f8f8f8;
        font-weight: bold;
    }

    .notification-item .title {
        font-size: 16px;
        color: #1ab394;
    }

    .notification-item .message {
        margin-top: 5px;
        color: #676a6c;
    }

    .notification-item .message ul {
        margin-top: 5px;
        padding-left: 20px;
    }

    .notification-item .time {
        font-size: 12px;
        color: #999;
    }
</style>
@endpush
@endsection