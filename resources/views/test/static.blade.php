@extends('shop.layouts.master')
@section('title', 'Trang chủ')
@section('content')

@include('shop.layouts.carousel')
<div id="page-wrapper">
    
    @foreach ($categories as $category)
        @php
            $hasProducts = $category->products->isNotEmpty() || $category->children->pluck('products')->flatten()->isNotEmpty();
        @endphp
    
        @if ($hasProducts)
        <hr>
            <h2><strong>{{ $category->name }}</strong></h2>
        <hr>
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
    
            {{-- Hiển thị danh mục con --}}
            @foreach ($category->children as $childCategory)
                @if ($childCategory->products->isNotEmpty())
                    <h3 class="subcategory-title">{{ $childCategory->name }}</h3>
                    <div class="row-cus">
                        @foreach ($childCategory->products->take(5) as $product)
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
                    </div>
                @endif
            @endforeach
        @endif
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