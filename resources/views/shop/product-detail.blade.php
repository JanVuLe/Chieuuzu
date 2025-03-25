@extends('shop.layouts.master')
@section('title', 'Chi tiết sản phẩm')
@push('styles')
<link href="{{ asset('assets/css/plugins/slick/slick.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
<style>
.product-detail-header {
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    background-size: cover;
    background-position: center;
}

.product-detail-header::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(255, 214, 103, 0.6); /* Lớp phủ vàng nhẹ */
}

.product-title {
    position: relative;
    background: #fff;
    padding: 10px 20px;
    border: 2px solid #8B0000;
    color: #8B0000;
    font-size: 24px;
    font-weight: bold;
    text-transform: uppercase;
}
</style>
@endpush
@section('content')
    <div class="product-detail-header" style="background-image: url('{{ asset('storage/banner/slide_2.jpg') }}');">
        <h1 class="product-title">CHI TIẾT SẢN PHẨM</h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox product-detail">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="product-images">
                                @if($product->images->isNotEmpty())
                                    @foreach($product->images as $image)
                                        <div>
                                            <img src="{{ asset('storage/' . $image->image_url) }}" class="image-imitation"
                                                alt="{{ $product->name }}"
                                                style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: cover; padding: 0%;">
                                        </div>
                                    @endforeach
                                @else
                                    <p>Chưa có hình ảnh</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h2 class="font-bold m-b-xs">
                                {{ $product->name }}
                            </h2>
                            <div class="m-t-md">
                                @php
                                    $activeDiscount = $product->discounts()
                                        ->where('status', 'active')
                                        ->where('start_date', '<=', now())
                                        ->where('end_date', '>=', now())
                                        ->orderBy('percentage', 'desc')
                                        ->first();
                                    $originalPrice = $product->price;
                                    $discountedPrice = $activeDiscount ? $originalPrice * (1 - $activeDiscount->percentage / 100) : null;
                                @endphp
                                @if($activeDiscount)
                                    <h2 class="product-main-price" style="text-decoration: line-through;">
                                        {{ number_format($originalPrice, 0, ',', '.') }} đ
                                    </h2>
                                    <h2 class="product-main-price">
                                        {{ number_format($discountedPrice, 0, ',', '.') }} đ
                                    </h2>
                                @else
                                    <h2 class="product-main-price">
                                        {{ number_format($originalPrice, 0, ',', '.') }} đ
                                    </h2>
                                @endif
                                <p><strong>Tồn kho:</strong> {{ $product->total_stock }} sản phẩm</p>
                            </div>
                            <hr>
                            <h4>Mô tả sản phẩm:</h4>
                            <div class="small text-muted">
                                {{ $product->description }}
                            </div>
                            <h4>Danh mục sản phẩm:</h4>{{ $product->category->name }}
                            <hr>
                            <div>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm add-to-cart" data-slug="{{ $product->slug }}">
                                        <i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng
                                    </button>
                                    <button class="btn btn-white btn-sm"><i class="fa fa-star"></i> Thêm vào danh sách theo dõi</button>
                                    <button class="btn btn-white btn-sm"><i class="fa fa-envelope"></i> Liên hệ với CSKH</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="subcategory-title">
                    <strong>SẢN PHẨM TƯƠNG TỰ</strong>
                </h4>
            </div>
            @foreach ($relatedProducts as $related)
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        @if($related->images->isNotEmpty())
                            <div>
                                <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                                    class="image-imitation"
                                    alt="{{ $related->name }}"
                                    style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: cover; padding: 0%;">
                            </div>
                        @else
                            <p>Chưa có hình ảnh</p>
                        @endif
                        <div class="product-desc">
                            @php
                                $relatedDiscount = $related->discounts()
                                    ->where('status', 'active')
                                    ->where('start_date', '<=', now())
                                    ->where('end_date', '>=', now())
                                    ->orderBy('percentage', 'desc')
                                    ->first();
                                $relatedOriginalPrice = $related->price;
                                $relatedDiscountedPrice = $relatedDiscount ? $relatedOriginalPrice * (1 - $relatedDiscount->percentage / 100) : null;
                            @endphp
                            @if($relatedDiscount)
                                <span class="product-price" style="text-decoration: line-through;">
                                    {{ number_format($relatedOriginalPrice, 0, ',', '.') }} đ
                                </span>
                                <span class="product-price-discounted">
                                    {{ number_format($relatedDiscountedPrice, 0, ',', '.') }} đ
                                </span>
                            @else
                                <span class="product-price">
                                    {{ number_format($relatedOriginalPrice, 0, ',', '.') }} đ
                                </span>
                            @endif
                            <a href="{{ route('shop.product', $related->slug) }}" class="product-name">
                                {{ $related->name }}
                            </a>
                            <div class="small m-t-xs">
                                {{ Str::limit($related->description, 50) }}
                            </div>
                            <div class="m-t text-right">
                                <a href="{{ route('shop.product', $related->slug) }}" class="btn btn-xs btn-outline btn-primary">
                                    Xem chi tiết <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@push('scripts')
<script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.product-images').slick({
            dots: true
        });
    });

    $('.add-to-cart').on('click', function() {
        var slug = $(this).data('slug');
        $.ajax({
            url: '{{ route("shop.cart.add", ":slug") }}'.replace(':slug', slug),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('.badge.bg-danger').text(response.cart_count);
                    alert(response.message);
                }
            },
            error: function() {
                alert('Đã có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    });
</script>
@endpush

@endsection