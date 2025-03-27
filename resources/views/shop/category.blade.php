@extends('shop.layouts.master')
@section('title', $category->name)
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">{{ $category->name }}</h2>
            @if ($products->isEmpty())
                <p class="text-center">Hiện không có sản phẩm.</p>
            @else
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="product-item">
                                <div class="product-image">
                                    @if ($product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" alt="{{ $product->name }}">
                                    @else
                                        <img src="{{ asset('storage/default-product.png') }}" alt="No Image">
                                    @endif
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name">{{ $product->name }}</h3>
                                    <p class="product-price">{{ number_format($product->price, 0, ',', '.') }} VND</p>
                                    <a href="{{ route('shop.product', $product->slug) }}" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection