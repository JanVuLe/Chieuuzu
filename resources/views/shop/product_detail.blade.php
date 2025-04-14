@extends('shop.layouts.master')
@section('title', 'Chi tiết sản phẩm')
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
                            <div class="ibox">
                                <div class="ibox-title new-title">
                                    <h2>Thông tin sản phẩm</h2>
                                </div>
                                <div class="ibox-content" style="padding-left: 15px; padding-top: 15px; padding-bottom: 30px; border: 1px solid; border-radius: 0px 5px 5px 5px;">
                                    <div class="item-warranty-info">
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/icon/product.png') }}">
                                        </div>
                                        <div class="description">
                                            <h3>
                                                {{ $product->name }}
                                           </h3>
                                        </div>
                                    </div>
                                    <div class="item-warranty-info">
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/icon/categorization.png') }}">
                                        </div>
                                        <div class="description">
                                            <p class="font-bold">{{ $product->category->name }}</p>
                                        </div>
                                    </div>
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
                                    <div class="item-warranty-info">
                                        @if ($activeDiscount)
                                            <div class="icon">
                                                <img src="{{ asset('assets/img/icon/price-tag.png') }}">
                                            </div>
                                            <div class="description">
                                                <p class="product-main-price m-r" style="text-decoration: line-through;">
                                                    {{ number_format($originalPrice, 0, ',', '.') }} đ
                                                </p>
                                                |
                                                <p class="product-main-price-discounted m-l m-r">
                                                    {{ number_format($discountedPrice, 0, ',', '.') }} đ
                                                </p>
                                                |
                                                <p class="product-main-price-discounted m-l">
                                                    Giảm {{ $activeDiscount->percentage }}%
                                                </p>
                                            </div>
                                        @else
                                            <div class="icon">
                                                <img src="{{ asset('assets/img/icon/price-tag.png') }}">
                                            </div>
                                            <div class="description">
                                                <p class="product-main-price m-l">
                                                    {{ number_format($originalPrice, 0, ',', '.') }} đ
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="item-warranty-info">
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/icon/product-description.png') }}">
                                        </div>
                                        <div class="description">
                                            <p class="font-bold">Mô tả sản phẩm: </p> 
                                            <p class="m-l">{{ $product->description }}</p>
                                        </div>
                                    </div>
                                    <div class="item-warranty-info">
                                        <div class="icon">
                                            <img src="{{ asset('assets/img/icon/in-stock.png') }}">
                                        </div>
                                        <div class="description">
                                            <p class="font-bold">Còn {{ $product->total_stock }} sản phẩm</p>
                                        </div>
                                    </div>
                                    <div class="item-warranty-info">
                                        <div class="icon">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= round($averageRating))
                                                    <span style="font-size: 20px; color: #ffd700;">★</span>
                                                @else
                                                    <span style="font-size: 20px; color: #ccc;">☆</span>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="description">
                                            <p class="font-bold">{{ $ratingCount }} đánh giá</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        {{-- Đánh giá sản phẩm --}}
                        <div class="col-lg-5">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    ĐÁNH GIÁ SẢN PHẨM
                                </div>
                                <div class="panel-body">
                                    <h3>Đánh giá {{ $product->name }}</h3>
                                    <div class="rating-summary" style="margin-top: 20px;">
                                        <div class="average-rating" style="display: flex; align-items: center; margin-bottom: 15px;">
                                            <span style="font-size: 24px; color: #ffd700;">★</span>
                                            <span style="font-size: 28px; font-weight: bold; margin-left: 5px;">{{ number_format($averageRating, 1) }}</span>
                                            <span style="font-size: 18px; color: #666; align-self: flex-end; padding-bottom: 3px;">/5</span>
                                        </div>
                                        <div class="rating-list">
                                            @for ($i = 5; $i >= 1; $i--)
                                                @php
                                                    $ratingPercentage = $ratingCount > 0 ? ($ratingDistribution[$i] / $ratingCount) * 100 : 0;
                                                @endphp
                                                <div class="rating-item" style="display: flex; align-items: center; margin-bottom: 10px">
                                                    <span style="width: 50px;">{{ $i }} ★</span>
                                                    <div class="progress" style="flex-grow: 1; height: 10px; margin: 0 10px; background-color: #e0e0e0; border-radius: 5px;">
                                                        <div class="progress-bar" style="width: {{ $ratingPercentage }}%; background-color: #ffd700; border-radius: 5px;"></div>
                                                    </div>
                                                    <span style="width: 60px; text-align: right;">{{ number_format($ratingPercentage,1) }} %</span>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- Đánh giá --}}
                                    <div class="review-product">
                                        <p class="has-text-centered">Bạn đánh giá sao về sản phẩm này?</p>
                                        <div class="has-text-centered">
                                            @if (Auth::check())
                                                @if (!$hasReviewed)
                                                    <button class="text-white reviewProduct" data-product-id="{{ $product->id }}">
                                                        Đánh giá ngay
                                                    </button>
                                                @elseif ($hasReviewed)
                                                    <p style="color: #e74c3c;">Bạn đã đánh giá sản phẩm này rồi!</p>
                                                @endif
                                            @else
                                                <p style="color: #e74c3c;">Vui lòng <a href="{{ route('shop.login') }}" style="color: #007bff;">đăng nhập</a> để đánh giá sản phẩm!</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Modal đánh giá sản phẩm --}}
                                    <div class="modal fade" id="reviewProductModal" tabindex="-1" role="dialog" aria-labelledby="reviewProductModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm</h5>
                                                    <h3>{{ $product->name }}</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="reviewForm">
                                                        @csrf
                                                        <input type="hidden" name="product_id" id="reviewProductId">
                                                        <div class="mb-3">
                                                            <label for="rating" class="form-label">Điểm đánh giá</label>
                                                            <div class="star-rating">
                                                                <div class="star-item">
                                                                    <span class="star-wrapper">
                                                                        <img class="star" data-value="1" src="{{ asset('assets/svg/star-svgrepo-com.svg') }}" alt="1 sao - Rất Tệ">
                                                                    </span>
                                                                    <span class="star-label">Rất Tệ</span>
                                                                </div>
                                                                <div class="star-item">
                                                                    <span class="star-wrapper">
                                                                        <img class="star" data-value="2" src="{{ asset('assets/svg/star-svgrepo-com.svg') }}" alt="2 sao - Tệ">
                                                                    </span>
                                                                    <span class="star-label">Tệ</span>
                                                                </div>
                                                                <div class="star-item">
                                                                    <span class="star-wrapper">
                                                                        <img class="star" data-value="3" src="{{ asset('assets/svg/star-svgrepo-com.svg') }}" alt="3 sao - Bình thường">
                                                                    </span>
                                                                    <span class="star-label">Bình thường</span>
                                                                </div>
                                                                <div class="star-item">
                                                                    <span class="star-wrapper">
                                                                        <img class="star" data-value="4" src="{{ asset('assets/svg/star-svgrepo-com.svg') }}" alt="4 sao - Tốt">
                                                                    </span>
                                                                    <span class="star-label">Tốt</span>
                                                                </div>
                                                                <div class="star-item">
                                                                    <span class="star-wrapper">
                                                                        <img class="star" data-value="5" src="{{ asset('assets/svg/star-svgrepo-com.svg') }}" alt="5 sao - Tuyệt vời">
                                                                    </span>
                                                                    <span class="star-label">Tuyệt vời</span>
                                                                </div>
                                                            </div>
                                                            <!-- Ô nhập ẩn để lưu giá trị đánh giá -->
                                                            <input type="hidden" id="rating" name="rating" value="0" required>
                                                        </div>
                                                        <hr>
                                                        <div class="mb-3">
                                                            <label for="comment" class="form-label">Nhận xét</label>
                                                            <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Xin mời chia sẻ một số cảm nhận về sản phẩm."></textarea>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-primary" id="sendReviewRequest">Gửi đánh giá</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    {{-- Bình luận sản phẩm --}}
                                    <div class="reviews-list" style="margin-top: 30px;">
                                        @if($product->reviews->isNotEmpty())
                                            @foreach($product->reviews as $review)
                                                <div class="review-item" style="border-bottom: 1px solid #e0e0e0; padding: 15px 0;">
                                                    {{-- Tên người đánh giá --}}
                                                    <div class="reviewer-name" style="font-weight: bold; margin-bottom: 5px;">
                                                        {{ $review->user->name ?? 'Ẩn danh' }}
                                                    </div>
                                                    {{-- Số sao đánh giá --}}
                                                    <div class="review-rating" style="margin-bottom: 5px;">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <span style="color: #ffd700;">★</span>
                                                            @else
                                                                <span style="color: #ccc;">☆</span>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    {{--Nội dung đánh giá --}}
                                                    <div class="review-comment" style="color: #333;">
                                                        {{ $review->comment ?? 'Không có bình luận' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                            {{-- Phân trang --}}
                                            <div class="pagination" style="margin-top: 20px;">
                                                {{ $reviews->links() }}
                                            </div>
                                        @else
                                            <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Sản phẩm tương tự --}}
                        <div class="col-lg-7">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    SẢN PHẨM TƯƠNG TỰ
                                </div>
                                <div class="panel-body">
                                    @if($relatedProducts->isNotEmpty())
                                        <div class="related-products-slider">
                                            @foreach($relatedProducts as $related)
                                                <div class="product-box" style="margin: 0 10px;">
                                                    <!-- Hình ảnh sản phẩm -->
                                                    @if($related->images->isNotEmpty())
                                                        <div class="product-image" style="position: relative; text-align: center;">
                                                            <a href="{{ route('shop.product', $related->slug) }}">
                                                                <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                                                                     alt="{{ $related->name }}" 
                                                                     style="max-width: 100%; height: 150px; object-fit: cover; border-radius: 5px;">
                                                            </a>
                                                            <!-- Phần trăm giảm giá (nếu có) -->
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
                                                                <span class="discount-badge" 
                                                                      style="position: absolute; top: 5px; left: 5px; background-color: #e74c3c; color: white; padding: 2px 8px; border-radius: 3px; font-size: 12px;">
                                                                    -{{ $relatedDiscount->percentage }}%
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="product-image" style="text-align: center;">
                                                            <p style="color: #999;">Chưa có hình ảnh</p>
                                                        </div>
                                                    @endif
                                
                                                    <!-- Thông tin sản phẩm -->
                                                    <div class="product-desc" style="padding: 10px; background-color: #2c3e50; border-radius: 0 0 5px 5px;">
                                                        <!-- Tên sản phẩm (1 dòng) -->
                                                        <a href="{{ route('shop.product', $related->slug) }}" 
                                                           class="product-name" 
                                                           style="font-weight: bold; color: #fff; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                            {{ $related->name }}
                                                        </a>
                                
                                                        <!-- Giá sản phẩm -->
                                                        <div class="product-price" style="margin-top: 5px; top: -37px;">
                                                            @if($relatedDiscount)
                                                                <span style="text-decoration: line-through; color: #ccc; font-size: 12px;">
                                                                    {{ number_format($relatedOriginalPrice, 0, ',', '.') }} đ
                                                                </span>
                                                                <span style="color: #fff; font-weight: bold; margin-left: 5px;">
                                                                    {{ number_format($relatedDiscountedPrice, 0, ',', '.') }} đ
                                                                </span>
                                                            @else
                                                                <span style="color: #fff; font-weight: bold;">
                                                                    {{ number_format($relatedOriginalPrice, 0, ',', '.') }} đ
                                                                </span>
                                                            @endif
                                                        </div>
                                
                                                        <!-- Nút xem chi tiết -->
                                                        <div class="text-right" style="margin-top: 10px;">
                                                            <a href="{{ route('shop.product', $related->slug) }}" 
                                                               class="btn btn-sm btn-outline btn-light" 
                                                               style="color: #fff; border-color: #fff;">
                                                                Xem chi tiết <i class="fa fa-long-arrow-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>Không có sản phẩm tương tự nào.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

@push('styles')
<link href="{{ asset('assets/css/plugins/slick/slick.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<link href="{{ asset('css/shop.css') }}" rel="stylesheet">
<style>
.star-rating {
    display: flex;
    justify-content: space-between;
    width: 100%;
    max-width: 500px;
    margin: 10px auto;
}
.star-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
}
.star-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 24px;
    height: 24px;
}
.star {
    width: 24px;
    height: 24px;
    cursor: pointer;
    filter: grayscale(100%);
    transition: filter 0.2s;
}

.star:hover,
.star.selected {
    filter: none;
}

.star-labels {
    display: flex;
    justify-content: space-between;
    width: 200px;
    margin: 5px auto;
    font-size: 12px;
    color: #333;
    text-align: center;
}

.star-labels span {
    flex: 1;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.product-images').slick({
            dots: true
        });

        $('.related-products-slider').slick({
            slidesToShow: 3, // Hiển thị 3 sản phẩm cùng lúc
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000,
            arrows: false,
            dots: false,
            responsive: [
                {
                    breakpoint: 768, // Dưới 768px (mobile)
                    settings: {
                        slidesToShow: 1 // Chỉ hiển thị 1 sản phẩm
                    }
                },
                {
                    breakpoint: 992, // Dưới 992px (tablet)
                    settings: {
                        slidesToShow: 2 // Hiển thị 2 sản phẩm
                    }
                }
            ]
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

    $('.star').on('click', function() {
        const ratingValue = $(this).data('value');
        
        // Cập nhật giá trị ô nhập ẩn
        $('#rating').val(ratingValue);

        // Xóa lớp 'selected' khỏi tất cả ngôi sao
        $('.star').removeClass('selected');

        // Thêm lớp 'selected' cho các ngôi sao có data-value nhỏ hơn hoặc bằng giá trị được chọn
        $('.star').each(function() {
            const starValue = $(this).data('value');
            if (starValue <= ratingValue) {
                $(this).addClass('selected');
            }
        });
    });

    // Tô sáng ngôi sao khi rê chuột
    $('.star').on('mouseover', function() {
        $(this).addClass('hover').addClass('hover');
        $(this).nextAll('.star').removeClass('hover');
    });

    // Xóa hiệu ứng rê chuột khi chuột rời khỏi
    $('.star-rating').on('mouseleave', function() {
        $('.star').removeClass('hover');
    });

    $('.reviewProduct').on('click', function() {
        const productId = $(this).data('product-id');
        $('#reviewProductId').val(productId); // Gán product_id vào input ẩn
        $('#reviewProductModal').modal('show'); // Hiển thị modal đánh giá
    });

    // Xử lý đánh giá
    $('#sendReviewRequest').on('click', function() {
        const formData = $('#reviewForm').serialize(); // Lấy dữ liệu từ form
        const $button = $(this);
        $button.prop('disabled', true).text('Đang gửi...');
        // Kiểm tra xem người dùng đã chọn số sao chưa
        if ($('#rating').val() == 0) {
            toastr.error('Vui lòng chọn số sao để đánh giá!', 'Lỗi');
            $button.prop('disabled', false).text('Gửi đánh giá');
            return;
        }

        $.ajax({
            url: '{{ route("shop.review.store") }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.success, 'Thành công');
                    $('#reviewProductModal').modal('hide');
                    $('#reviewForm')[0].reset();
                    $('.star').removeClass('selected');
                    $('#rating').val(0);

                    // Cập nhật giao diện trực tiếp từ phản hồi
                    $('.reviews-list').html(response.reviews_html);
                    $('.average-rating').html(response.average_rating_html);
                    $('.rating-list').html(response.rating_list_html);
                    $('.review-product').html(response.review_product_html);
                    $('.item-warranty-info .description .font-bold').last().text(response.rating_count + ' đánh giá');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    toastr.error('Vui lòng <a href="{{ route("shop.login") }}" style="color: #fff; text-decoration: underline;">đăng nhập</a> để gửi đánh giá!', 'Lỗi', {
                        allowHtml: true
                    });
                } else {
                    const errorMessage = xhr.responseJSON && xhr.responseJSON.error 
                        ? xhr.responseJSON.error 
                        : 'Đã có lỗi xảy ra, vui lòng thử lại!';
                    toastr.error(errorMessage, 'Lỗi');
                }
            },
            complete: function() {
                $button.prop('disabled', false).text('Gửi đánh giá');
            }
        });
    });
</script>
@endpush

@endsection