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
                    Đơn hàng #{{ $order->id }} - {{ ucfirst($order->status) }}
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
                            Đơn hàng đã giao thành công.
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

    .notification-item .time {
        font-size: 12px;
        color: #999;
    }
</style>
@endpush
@endsection