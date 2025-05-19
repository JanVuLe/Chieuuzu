@extends('shop.layouts.master')
@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title new-title">
                    <h2>Kết quả tìm kiếm cho: "{{ $query }}"</h2>
                    <p>Tìm thấy {{ $products->total() }} sản phẩm</p>
                </div>
                <div class="ibox-content">
                    <div class="product-carousel">
                        @foreach($products as $product)
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
                    </div>
                    <div class="text-center">
                        {{ $products->appends(['query' => $query])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .row-cus{
        display: flex;
    }
    .product-item{
        width: 250px;
        padding: 10px;
        box-sizing: border-box; 
    }
    .product-box{
        max-width: 250px;
        margin: 0 10px;
        overflow: hidden;
    }
    .image-imitation{
        height: 249px;
        width: 100%;
        object-fit: cover;
        padding: 0;
        max-width: 100%;
        display: block;
        margin: 0 auto;
    }
    .product-carousel {
        margin: 0 -10px;
    }
    .product-price{
        margin-left: -1px;
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
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
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