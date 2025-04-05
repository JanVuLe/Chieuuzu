@extends('shop.layouts.master')

@section('title', 'Thông báo đơn hàng')

@section('content')
<div class="notifications-container">
    <h1 class="text-center mb-4">Thông báo đơn hàng</h1>

    <!-- Thông báo nhắc nhở đánh giá -->
    @if($reviewableProducts->isNotEmpty())
        <div class="notification-item unread">
            <div class="title">Nhắc nhở đánh giá sản phẩm</div>
            <div class="message">
                Bạn có sản phẩm đã nhận nhưng chưa đánh giá:
                <ul>
                    @foreach($reviewableProducts as $product)
                        <li>
                            <a href="{{ route('shop.product', $product->slug) }}#reviewModal" class="text-decoration-none">
                                {{ $product->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="time">{{ now()->diffForHumans() }}</div>
        </div>
    @endif

    <!-- Danh sách thông báo -->
    @if ($notifications->isEmpty())
        <p class="text-center">Bạn chưa có thông báo nào.</p>
    @else
        @foreach ($notifications as $notification)
            <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
                @if (isset($notification->data['order_id']))
                    <a href="{{ route('shop.notification.markAsRead', $notification->id) }}" class="text-decoration-none">
                        <div class="title">{{ $notification->title }}</div>
                        <div class="message">{{ $notification->message }}</div>
                        <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                    </a>
                @else
                    <div class="title">{{ $notification->title }}</div>
                    <div class="message">{{ $notification->message }}</div>
                    <div class="time">{{ $notification->created_at->diffForHumans() }}</div>
                @endif
            </div>
        @endforeach

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<!-- Modal đánh giá sản phẩm -->
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
            transition: background-color 0.3s ease;
        }
        .notification-item:hover {
            background-color: #f1f3f5;
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
        .notification-item a {
            color: inherit;
            text-decoration: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Xử lý khi nhấp vào thông báo đánh giá để điền thông tin vào modal
        document.querySelectorAll('[data-bs-target="#reviewModal"]').forEach(item => {
            item.addEventListener('click', function () {
                const productId = this.getAttribute('data-product-id');
                const productName = this.getAttribute('data-product-name');
                document.getElementById('reviewProductId').value = productId;
                document.getElementById('reviewProductName').innerText = productName;
            });
        });
    </script>
@endpush
@endsection