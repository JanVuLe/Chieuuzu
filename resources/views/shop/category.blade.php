@extends('shop.layouts.master')
@section('title', $category->name)
@section('content')
<div class="product-detail-header" style="background-image: url('{{ asset('storage/banner/slide_2.jpg') }}');">
    <h1 class="product-title">SẢN PHẨM : {{ $category->name }}</h1>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-3">
            <div class="sidebar">
                <div class="sidebar-title">
                    <h4>Danh mục sản phẩm</h4>
                </div>
                <ul class="list-unstyled">
                    @foreach ($categories as $category)
                        <li class="mb-2 category-box">
                            <a href="{{ route('shop.category', $category->slug) }}" class="text-decoration-none text-dark">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <br>
            <div class="sidebar-contact">
                <div class="sidebar-contact-title">
                    <h4>Thông tin</h4>
                </div>
                <ul class="list-unstyled">
                    <li class="mb-2 category-box">
                        <a href="{{ route('shop.contact') }}" class="text-decoration-none text-dark">
                            Liên hệ
                        </a>
                    </li>
                    <li class="mb-2 category-box">
                        <a href="{{ route('shop.news.index') }}" class="text-decoration-none text-dark">
                            Tin tức
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="ibox">
                            <div class="ibox-content product-box">
                                <div class="product-imitation">
                                    @if($product->images->isNotEmpty())
                                        <div>
                                            <img src="{{ asset('storage/' . $product->images->first()->image_url) }}" 
                                                class="image-imitation"
                                                alt="{{ $product->name }}">
                                        </div>
                                    @else
                                        <p>Chưa có hình ảnh</p>
                                    @endif
                                </div>
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
                                    <a href="{{ route('shop.product', $product->slug) }}" class="product-name text-truncate">
                                        {{ $product->name }}
                                    </a>
                                    <div class="small m-t-xs text-truncate">
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
            @if ($products->isEmpty())
                <p class="text-center">Hiện không có sản phẩm.</p>
            @else

            @endif
        </div>
    </div>
</div>
@push('styles')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<style>
.product-item{
    width: 250px;
}
.product-name{
    white-space: nowrap; /* Ngăn xuống dòng */
    overflow: hidden; /* Ẩn phần vượt quá */
    text-overflow: ellipsis; /* Thêm dấu ... */
    font-size: 1.1rem;
    color: #343a40;
    text-decoration: none;
}
.product-name:hover {
    color: #007bff;
}
.small.m-t-xs {
    white-space: nowrap; /* Ngăn xuống dòng */
    overflow: hidden; /* Ẩn phần vượt quá */
    text-overflow: ellipsis; /* Thêm dấu ... */
    color: #6c757d;
}
.product-box{
    max-width: 250px;
    margin-left: 10px;
    margin-right: 10px;
}
.product-imitation{
    padding: 0;
}
.product-box img{
    margin-bottom: 0px;
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
@endsection