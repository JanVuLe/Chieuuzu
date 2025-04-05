@extends('shop.layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="order-detail-container" style="max-width: 800px; margin: 40px auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <h1 class="text-center mb-4">Chi tiết đơn hàng #{{ $order->id }}</h1>

    <!-- Thông tin đơn hàng -->
    <div class="order-info mb-4">
        <h3>Thông tin đơn hàng</h3>
        <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p>
        <p><strong>Địa chỉ giao hàng:</strong> {{ $order->shipping_address }}</p>
    </div>

    <!-- Danh sách sản phẩm trong đơn hàng -->
    <div class="order-details mb-4">
        <h3>Sản phẩm</h3>
        <!-- Nút "Đánh giá sản phẩm" tổng quát -->
        @if ($order->status == 'delivered')
            @php
                $hasUnreviewedProduct = false;
                foreach ($reviewableProducts as $productInfo) {
                    if (!$productInfo['hasReviewed']) {
                        $hasUnreviewedProduct = true;
                        break;
                    }
                }
            @endphp
            @if ($hasUnreviewedProduct)
                <div class="text-right mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#reviewModal">
                        <i class="fa fa-star"></i> Đánh giá sản phẩm
                    </button>
                </div>
            @endif
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                    <th>Đánh giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td>
                            <a href="{{ route('shop.product', $detail->product->slug) }}">
                                {{ $detail->product->name }}
                            </a>
                        </td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->price, 0, ',', '.') }} VNĐ</td>
                        <td>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VNĐ</td>
                        <td>
                            @if ($order->status == 'delivered' && !$reviewableProducts[$detail->product_id]['hasReviewed'])
                                <button class="btn btn-success btn-sm review-product" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#reviewModal" 
                                        data-product-id="{{ $detail->product_id }}" 
                                        data-product-name="{{ $detail->product->name }}">
                                    <i class="fa fa-star"></i> Đánh giá
                                </button>
                            @elseif ($reviewableProducts[$detail->product_id]['hasReviewed'])
                                <span class="text-muted">Đã đánh giá</span>
                            @else
                                <span class="text-muted">Chưa thể đánh giá</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Thông tin thanh toán -->
    @if ($order->payment)
        <div class="payment-info mb-4">
            <h3>Thông tin thanh toán</h3>
            <p><strong>Phương thức thanh toán:</strong> {{ $order->payment->payment_method }}</p>
            <p><strong>Trạng thái thanh toán:</strong> {{ $order->payment->status }}</p>
            <p><strong>Thời gian thanh toán:</strong> {{ $order->payment->created_at->format('d/m/Y H:i:s') }}</p>
        </div>
    @endif

    <!-- Nút quay lại -->
    <div class="text-center">
        <a href="{{ route('shop.notifications') }}" class="btn btn-primary">Quay lại thông báo</a>
    </div>
</div>

<!-- Modal Đánh giá sản phẩm -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('shop.review.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="product_id" id="reviewProductId">
                    <h6>Đánh giá sản phẩm: <span id="reviewProductName"></span></h6>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Điểm đánh giá (1-5):</label>
                        <select name="rating" id="rating" class="form-control" required>
                            <option value="1">1 sao</option>
                            <option value="2">2 sao</option>
                            <option value="3">3 sao</option>
                            <option value="4">4 sao</option>
                            <option value="5">5 sao</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Nhận xét:</label>
                        <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .order-detail-container {
            font-family: Arial, sans-serif;
        }
        .order-info, .order-details, .payment-info {
            border-bottom: 1px solid #e7eaec;
            padding-bottom: 20px;
        }
        .order-info h3, .order-details h3, .payment-info h3 {
            font-size: 1.5rem;
            color: #1ab394;
            margin-bottom: 15px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Xử lý khi nhấp vào nút đánh giá để điền thông tin vào modal
        document.querySelectorAll('.review-product').forEach(item => {
            item.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                document.getElementById('reviewProductId').value = productId;
                document.getElementById('reviewProductName').innerText = productName;
            });
        });

        // Nút "Đánh giá sản phẩm" tổng quát: mở modal cho sản phẩm đầu tiên chưa được đánh giá
        document.querySelector('.btn-success:not(.review-product)')?.addEventListener('click', function() {
            const firstUnreviewedProduct = document.querySelector('.review-product');
            if (firstUnreviewedProduct) {
                firstUnreviewedProduct.click();
            }
        });
    </script>
@endpush
@endsection