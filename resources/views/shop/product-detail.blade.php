@extends('shop.layouts.master')
@section('title', 'Chi tiết sản phẩm')
@push('styles')
<link href="{{ asset('admin_assets/css/plugins/slick/slick.css') }}" rel="stylesheet">
<link href="{{ asset('admin_assets/css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
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
                                <h2 class="product-main-price">{{ number_format($product->price, 0, ',', '.') }} đ</h2>
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
                                    <button class="btn btn-primary btn-sm"><i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng</button>
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
@push('scripts')
<script src="{{ asset('admin_assets/js/plugins/slick/slick.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.product-images').slick({
            dots: true
        });
    });
</script>
@endpush

@endsection