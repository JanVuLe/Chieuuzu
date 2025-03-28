@extends('shop.layouts.master')
@section('title', 'Chi tiết sản phẩm')
@push('styles')
<link href="{{ asset('assets/css/plugins/slick/slick.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
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
                                    <h2 class="product-main-price" style="text-decoration: line-through;">
                                        {{ number_format($originalPrice, 0, ',', '.') }} đ
                                    </h2>
                                    <h2 class="product-main-price">
                                        {{ number_format($discountedPrice, 0, ',', '.') }} đ
                                    </h2>
                                @else
                                    <h2 class="product-main-price">
                                        {{ number_format($originalPrice, 0, ',', '.') }} đ
                                    </h2>
                                @endif
                                <p><strong>Tồn kho:</strong> {{ $product->total_stock }} sản phẩm</p>
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
                                    <button class="btn btn-primary btn-sm add-to-cart" data-slug="{{ $product->slug }}">
                                        <i class="fa fa-cart-plus"></i> Thêm vào giỏ hàng
                                    </button>
                                    <button class="btn btn-white btn-sm contact-support" data-product-id="{{ $product->id }}">
                                        <i class="fa fa-envelope"></i> Liên hệ với CSKH
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="subcategory-title">
                    <strong>SẢN PHẨM TƯƠNG TỰ</strong>
                </h4>
            </div>
            @foreach ($relatedProducts as $related)
            <div class="col-md-3">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        @if($related->images->isNotEmpty())
                            <div>
                                <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                                    class="image-imitation"
                                    alt="{{ $related->name }}"
                                    style="max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: cover; padding: 0%;">
                            </div>
                        @else
                            <p>Chưa có hình ảnh</p>
                        @endif
                        <div class="product-desc">
                            @php
                                $relatedDiscount = $related->discounts()
                                    ->where('status', 'active')
                                    ->where('start_date', '<=', now())
                                    ->where('end_date', '>=', now())
                                    ->orderBy('percentage', 'desc')
                                    ->first();
                                $relatedOriginalPrice = $related->price;
                                $relatedDiscountedPrice = $relatedDiscount ? $relatedOriginalPrice * (1 - $relatedDiscount->percentage / 100) : null;
                            @endphp
                            @if($relatedDiscount)
                                <span class="product-price" style="text-decoration: line-through;">
                                    {{ number_format($relatedOriginalPrice, 0, ',', '.') }} đ
                                </span>
                                <span class="product-price-discounted">
                                    {{ number_format($relatedDiscountedPrice, 0, ',', '.') }} đ
                                </span>
                            @else
                                <span class="product-price">
                                    {{ number_format($relatedOriginalPrice, 0, ',', '.') }} đ
                                </span>
                            @endif
                            <a href="{{ route('shop.product', $related->slug) }}" class="product-name">
                                {{ $related->name }}
                            </a>
                            <div class="small m-t-xs">
                                {{ Str::limit($related->description, 50) }}
                            </div>
                            <div class="m-t text-right">
                                <a href="{{ route('shop.product', $related->slug) }}" class="btn btn-xs btn-outline btn-primary">
                                    Xem chi tiết <i class="fa fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if ($relatedProducts->isEmpty())
                <div class="col-lg-12">
                    <p>Không có sản phẩm tương tự</p>
                </div>
                
            @endif
        </div>
    </div>

    <!-- Modal Liên hệ CSKH -->
    <div class="modal fade" id="contactSupportModal" tabindex="-1" role="dialog" aria-labelledby="contactSupportModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactSupportModalLabel">Liên hệ với CSKH</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="contactSupportForm">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">
                            <label for="message">Nội dung yêu cầu hỗ trợ:</label>
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Nhập nội dung yêu cầu hỗ trợ..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="sendSupportRequest">Gửi yêu cầu</button>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.product-images').slick({
            dots: true
        });
    });

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $('.add-to-cart').on('click', function() {
        var slug = $(this).data('slug');
        $.ajax({
            url: '{{ route("shop.cart.add", ":slug") }}'.replace(':slug', slug),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Hiển thị thông báo thành công
                    toastr.success(response.message, 'Thành công');
                    // Cập nhật số lượng giỏ hàng
                    $('.badge.bg-danger').text(response.cart_count);
                }
            },
            error: function() {
                // Hiển thị thông báo lỗi
                toastr.error('Đã có lỗi xảy ra, vui lòng thử lại!', 'Lỗi');
            }
        });
    });

    $('.contact-support').on('click', function() {
        const productId = $(this).data('product-id');
        $('#product_id').val(productId); // Gán product_id vào input ẩn
        $('#contactSupportModal').modal('show'); // Hiển thị modal
    });

    $('#sendSupportRequest').on('click', function() {
        const formData = $('#contactSupportForm').serialize(); // Lấy dữ liệu từ form

        $.ajax({
            url: '{{ route("shop.contact.support") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, 'Thành công');
                    $('#contactSupportModal').modal('hide'); // Ẩn modal sau khi gửi thành công
                }
            },
            error: function() {
                toastr.error('Đã có lỗi xảy ra, vui lòng thử lại!', 'Lỗi');
            }
        });
    });
</script>
@endpush

@endsection