@extends('shop.layouts.master')
@section('title', 'Trang chủ')
@section('content')

@include('shop.layouts.carousel')

@foreach ($categories as $category)
    @php
        $hasProducts = $category->products->isNotEmpty() || $category->children->pluck('products')->flatten()->isNotEmpty();
    @endphp

    @if ($hasProducts)
    <hr>
        <h3 class="category-title">{{ $category->name }}</h3>
    <hr>
        <div class="row">
            @if ($category->products->isNotEmpty())
                @foreach ($category->products->take(4) as $product)
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                    @if($product->images->isNotEmpty())
                                        <div>
                                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                                class="image-imitation"
                                                alt="{{ $product->name }}"
                                                style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: cover; padding: 0%;">
                                        </div>
                                    @else
                                        <p>Chưa có hình ảnh</p>
                                    @endif
                                <div class="product-desc">
                                    <span class="product-price">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                    <a href="{{ route('shop.product', $product->id) }}" class="product-name">
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
                <h4 class="subcategory-title">{{ $childCategory->name }}</h4>
                <div class="row">
                    @foreach ($childCategory->products->take(4) as $product)
                        <div class="col-md-3">
                            <div class="ibox">
                                <div class="ibox-content product-box">
                                    @if($product->images->isNotEmpty())
                                        <div>
                                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                                class="image-imitation"
                                                alt="{{ $product->name }}"
                                                style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: cover; padding: 0%;">
                                        </div>
                                    @else
                                        <p>Chưa có hình ảnh</p>
                                    @endif
                                    <div class="product-desc">
                                        <span class="product-price">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                        <a href="{{ route('shop.product', $product->id) }}" class="product-name">
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

@endsection
