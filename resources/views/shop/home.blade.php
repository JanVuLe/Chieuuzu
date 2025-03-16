@extends('shop.layouts.master')
@section('title', 'Trang chủ')
@section('content')

@include('shop.layouts.carousel')

@foreach ($categories as $category)
    {{-- Kiểm tra xem danh mục cha hoặc danh mục con có sản phẩm không --}}
    @php
        $hasProducts = $category->products->isNotEmpty() || $category->children->pluck('products')->flatten()->isNotEmpty();
    @endphp

    {{-- Nếu danh mục cha hoặc danh mục con có sản phẩm, hiển thị danh mục --}}
    @if ($hasProducts)
        <h3 class="category-title">{{ $category->name }}</h3>

        {{-- Hiển thị sản phẩm của danh mục cha --}}
        <div class="row">
            @if ($category->products->isNotEmpty())
                @foreach ($category->products->take(4) as $product)
                    <div class="col-md-3">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-imitation">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-responsive">
                                </div>
                                <div class="product-desc">
                                    <span class="product-price">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                    <a href="{{ route('shop.product', $product->id) }}" class="product-name">
                                        {{ $product->name }}
                                    </a>
                                    <div class="small m-t-xs">
                                        {{ Str::limit($product->description, 50) }}
                                    </div>
                                    <div class="m-t text-right">
                                        <a href="{{ route('shop.product', $product->id) }}" class="btn btn-xs btn-outline btn-primary">
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
                                    <div class="product-imitation">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-responsive">
                                    </div>
                                    <div class="product-desc">
                                        <span class="product-price">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                                        <a href="{{ route('shop.product', $product->id) }}" class="product-name">
                                            {{ $product->name }}
                                        </a>
                                        <div class="small m-t-xs">
                                            {{ Str::limit($product->description, 50) }}
                                        </div>
                                        <div class="m-t text-right">
                                            <a href="{{ route('shop.product', $product->id) }}" class="btn btn-xs btn-outline btn-primary">
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
