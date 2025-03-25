@extends('admin.layouts.master')
@section('title', 'Chi tiết hóa đơn #' . $order->id)
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Chi tiết hóa đơn #{{ $order->id }}</h5>
        </div>
        <div class="ibox-content">
            <p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'N/A' }}</p>
            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 2) }} đ</p>
            <p><strong>Trạng thái:</strong> {{ $order->status }}</p>
            <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address ?? 'N/A' }}</p>
            <p><strong>Tỉnh/Thành:</strong> {{ $order->province ?? 'N/A' }}</p>
            <p><strong>Quận/Huyện:</strong> {{ $order->district ?? 'N/A' }}</p>
            <p><strong>Phường/Xã:</strong> {{ $order->ward ?? 'N/A' }}</p>
            <p><strong>Đường:</strong> {{ $order->street ?? 'N/A' }}</p>
            <p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Ngày cập nhật:</strong> {{ $order->updated_at->format('d/m/Y H:i:s') }}</p>

            <h4>Chi tiết sản phẩm</h4>
            <table class="table table-bordered m-xs">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá gốc</th>
                        <th>Giá sau khuyến mãi</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name ?? 'N/A' }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>
                            @if($detail->original_price && $detail->original_price > $detail->price)
                                {{ number_format($detail->original_price, 2) }} đ
                            @else
                                {{ number_format($detail->price, 2) }} đ
                            @endif
                        </td>
                        <td>
                            @if($detail->original_price && $detail->original_price > $detail->price)
                                {{ number_format($detail->price, 2) }} đ
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ number_format($detail->price * $detail->quantity, 2) }} đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    <label><strong>Trạng thái:</strong></label>
                    <select name="status" class="form-control m-xs">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                    <button type="submit" class="btn btn-warning mt-2 m-xs">Cập nhật trạng thái</button>
                </form>
            </div>
            <hr>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Quay lại</a>
        </div>
    </div>
</div>
@endsection