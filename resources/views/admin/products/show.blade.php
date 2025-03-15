@extends('admin.layouts.master')
@section('title', 'Xem chi tiết sản phẩm')
@push('styles')
    <link href="{{ asset('admin_assets/css/plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
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
                                    <h2 class="product-main-price">
                                        {{ number_format($product->price, 0, ',', '.') }} <small
                                            class="text-muted">VND</small>
                                    </h2>
                                </div>
                                <hr>
                                <h4>Danh mục</h4>
                                <div class="text-muted">
                                    {{ $product->category->name ?? 'Không có' }}
                                </div>
                                <hr>
                                <h4>Kho hàng</h4>
                                @if($product->warehouses->isNotEmpty())
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên kho</th>
                                                <th>Địa chỉ</th>
                                                <th>Số lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->warehouses as $warehouse)
                                                <tr>
                                                    <td>{{ $warehouse->id }}</td>
                                                    <td>{{ $warehouse->name }}</td>
                                                    <td>{{ $warehouse->location }}</td>
                                                    <td>{{ $warehouse->pivot->quantity }}</td> 
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-muted">Sản phẩm chưa có trong kho nào.</p>
                                @endif
                                <hr>
                                <h4>Mô tả</h4>
                                <div class="text-muted">
                                    {{ $product->description }}
                                </div>
                                <hr>
                                <h4>Dữ liệu</h4>
                                <div class="text-muted">
                                    ID: {{ $product->id }}
                                </div>
                                <div class="text-muted">
                                    Slug: {{ $product->slug }}
                                </div>
                                <div class="text-muted">
                                    Category_ID: {{ $product->category_id }}
                                </div>
                                <div class="text-muted">
                                    Discount_ID: {{ $product->discount_id }}
                                </div>
                                <hr>
                                <div>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.products.edit', $product->slug) }}"
                                            class="btn btn-primary btn-sm">Sửa</a>
                                        <a href="{{ route('admin.products.index') }}" class="btn btn-white btn-sm">Trở
                                            Về</a>
                                    </div>
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
            $(document).ready(function () {
                $('.product-images').slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    adaptiveHeight: true
                });
            });
        </script>
    @endpush
@endsection