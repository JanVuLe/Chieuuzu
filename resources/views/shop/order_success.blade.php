@extends('shop.layouts.master')
@section('title', 'Đặt hàng thành công')

@push('styles')
<style>
    .order-success-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .order-success-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .order-success-header h1 {
        color: #28a745;
        font-size: 32px;
        font-weight: bold;
    }

    .order-success-header p {
        color: #666;
        font-size: 16px;
    }

    .order-card {
        background: #fff;
        border: none;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .order-card-header {
        background: #007bff;
        color: #fff;
        padding: 15px;
        font-size: 20px;
        font-weight: 600;
    }

    .order-card-body {
        padding: 20px;
    }

    .order-info p {
        margin: 10px 0;
        font-size: 16px;
    }

    .order-info strong {
        color: #333;
        min-width: 120px;
        display: inline-block;
    }

    .order-details-table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .order-details-table th,
    .order-details-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .order-details-table th {
        background: #f1f1f1;
        font-weight: 600;
        color: #555;
    }

    .order-details-table td {
        color: #666;
    }

    .action-buttons {
        margin-top: 20px;
        text-align: right;
    }

    .btn-custom {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        transition: all 0.3s ease;
        color: #fff;
    }

    .btn-primary-custom {
        background: #007bff;
        border: none;
    }

    .btn-primary-custom:hover {
        background: #0056b3;
        color: #fff;
    }

    .btn-danger-custom {
        background: #dc3545;
        border: none;
    }

    .btn-danger-custom:hover {
        background: #b02a37;
        color: #fff;
    }
</style>
@endpush

@section('content')
<div class="order-success-container">
    <div class="order-success-header">
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã đặt hàng. Dưới đây là thông tin chi tiết về đơn hàng của bạn.</p>
    </div>
    
    <div class="order-card">
        <div class="order-card-header">
            Đơn hàng #{{ $order->id }}
        </div>
        <div class="order-card-body">
            <div class="order-info">
                <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} đ</p>
                <p><strong>Trạng thái:</strong> 
                    @switch($order->status)
                        @case('pending') Chờ xác nhận @break
                        @case('confirmed') Đã xác nhận @break
                        @case('processing') Đang xử lý @break
                        @case('shipped') Đã giao hàng @break
                        @case('delivered') Hoàn tất @break
                        @case('cancelled') Đã hủy @break
                        @case('failed') Thất bại @break
                        @default Không xác định
                    @endswitch
                </p>
                <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
            </div>

            <h5 style="margin-top: 20px; color: #333;">Chi tiết sản phẩm</h5>
            <table class="order-details-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} đ</td>
                        <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="action-buttons">
                @if($order->status === 'pending' || $order->status === 'confirmed')
                <button type="button" class="btn btn-danger-custom btn-custom" data-toggle="modal" data-target="#cancelOrderModal">
                    Hủy đơn hàng
                </button>
                @endif
                <a href="{{ route('shop.home') }}" class="btn btn-primary-custom btn-custom">Quay về trang chủ</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn hủy đơn hàng #{{ $order->id }} không? Hành động này không thể hoàn tác.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                <form action="{{ route('shop.order.cancel', $order->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Có</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#cancelOrderModal').on('shown.bs.modal', function () {
            $(this).find('.modal-body').focus();
        });

        $('#cancelOrderModal form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#cancelOrderModal').modal('hide');
                        window.location.href = '{{ route("shop.home") }}';
                    } else {
                        alert(response.error);
                    }
                },
                error: function(xhr) {
                    alert('Đã có lỗi xảy ra: ' + xhr.statusText);
                }
            });
        });
    });
</script>
@endpush
@endsection