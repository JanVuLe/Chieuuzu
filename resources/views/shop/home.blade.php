@extends('shop.layouts.master')
@section('title', 'Tân Phú Hưng - Chiếu Uzu & Cói')
@section('content')
@include('shop.layouts.carousel')
<div id="page-wrapper">
    @foreach ($categories as $category)
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title new-title">
                    <h2>
                        {{ $category->name }}
                    </h2>
                </div>
                <div class="ibox-content">
                    <div class="product-carousel">
                        @if ($category->products->isNotEmpty())
                            @foreach ($category->products as $product)
                                <div class="product-item">
                                    <div class="ibox">
                                        <div class="ibox-content product-box">
                                            @if($product->images->isNotEmpty())
                                                <div>
                                                    <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                                        class="image-imitation"
                                                        alt="{{ $product->name }}">
                                                </div>
                                            @else
                                                <p>Chưa có hình ảnh</p>
                                            @endif
                                            <div class="product-desc">
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
                                                    <span class="product-price-discounted">
                                                        {{ number_format($discountedPrice, 0, ',', '.') }} đ
                                                    </span>
                                                    <span class="product-price" style="text-decoration: line-through;">
                                                        {{ number_format($originalPrice, 0, ',', '.') }} đ
                                                    </span>
                                                @else
                                                    <span class="product-price">
                                                        {{ number_format($originalPrice, 0, ',', '.') }} đ
                                                    </span>
                                                @endif
                                                {{-- Kiểm tra tồn kho --}}
                                                @if($product->total_stock > 0)
                                                    <span class="text-success">Còn hàng</span>
                                                @else
                                                    <span class="text-danger">Hết hàng</span>
                                                @endif
                                                <a href="{{ route('shop.product', $product->slug) }}" class="product-name">
                                                    {{ $product->name }}
                                                </a>
                                                <div class="small m-t-xs">
                                                    {{ Str::limit($product->description, 50) }}
                                                </div>
                                                <div class="m-t text-right">
                                                    <a href="{{ route('shop.product', $product->slug) }}" class="btn btn-xs btn-outline btn-primary">
                                                        Xem chi tiết <i class="fa fa-long-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="emty-product">
                                <p><strong>Không có sản phẩm nào trong danh mục này.</strong></p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@push('styles')
<link href="{{ asset('css/shop.css') }}" rel="stylesheet">
<style>
    .row-cus{
        display: flex;
    }
    .product-item{
        width: 250px;
    }
    .product-box{
        max-width: 250px;
        margin-left: 10px;
        margin-right: 10px;
    }
    .image-imitation{
        height: 249px;
        width: 249px;
        object-fit: cover; 
        padding: 0%;
    }
    .product-price{
        margin-left: -1px;
    }
    .emty-productelement.style{
        text-align: center;
        margin-top: 20px;
    }
    .text-success {
        color: green;
        font-weight: bold;
    }

    .text-danger {
        color: red;
        font-weight: bold;
    }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function(){
        $('.product-carousel').slick({
            infinite: true,
            slidesToShow: 4, // Số sản phẩm hiển thị cùng lúc
            slidesToScroll: 1, // Số sản phẩm cuộn mỗi lần
            arrows: true, // Hiển thị nút điều hướng
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>
@endpush
@endsection