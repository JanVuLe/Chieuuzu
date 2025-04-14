<div class="review-product">
    <p class="has-text-centered">Bạn đánh giá sao về sản phẩm này?</p>
    <div class="has-text-centered">
        @if (Auth::check())
            @if (!$hasReviewed)
                <button class="text-white reviewProduct" data-product-id="{{ request()->input('product_id') }}">
                    Đánh giá ngay
                </button>
            @elseif ($hasReviewed)
                <p style="color: #e74c3c;">Bạn đã đánh giá sản phẩm này rồi!</p>
            @endif
        @else
            <p style="color: #e74c3c;">Vui lòng <a href="{{ route('shop.login') }}" style="color: #007bff;">đăng nhập</a> để đánh giá sản phẩm!</p>
        @endif
    </div>
</div>