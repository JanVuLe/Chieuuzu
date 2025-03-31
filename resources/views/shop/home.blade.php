@extends('shop.layouts.master')
@section('title', 'Trang chủ')
@push('styles')
<style>
.new-title{
    color: #fff;
    font-size: 16px;
    font-weight: bold;
    padding: 10px 20px 10px 25px;
    position: relative;
    display: inline-block;
    font-family: 'Quicksand', sans-serif;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    background: #186f4c;
    min-width: 250px;
    margin-left: -10px;
    margin-right: -10px;
}
.new-title h2::after{
    content: "";
    height: 1px;
    width: 1px;
    border-style: solid;
    border-width: 5px;
    position: absolute;
    bottom: -10px;
    left: 0;
    border-color: #186f4c #186f4c transparent transparent;
}
</style>
@endpush
@section('content')
<div id="page-wrapper">
    @foreach ($categories as $category)
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title new-title">
                    <h2>
                        @php
                            $hasProducts = $category->products->isNotEmpty() || $category->children->pluck('products')->flatten()->isNotEmpty();
                        @endphp
                        @if ($hasProducts)
                            <strong>{{ $category->name }}</strong>
                        @else
                            <strong>Chưa có sản phẩm</strong>
                        @endif
                    </h2>
                </div>
                <div class="ibox-content">
                    <div class="row-cus">
                        @if ($category->products->isNotEmpty())
                            @foreach ($category->products->take(5) as $product)
                                <div class="col-md-5">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@push('styles')
<style>
    .row-cus{
        display: flex;
    }
    .product-box{
        max-width: 170px;
    }
    .image-imitation{
        height: 168px;
        width: 168px;
        object-fit: cover; 
        padding: 0%;
    }
</style>
@endpush
@endsection