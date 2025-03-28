@extends('shop.layouts.master')
@section('title', 'Giỏ hàng')
@section('content')
<div class="product-detail-header" style="background-image: url('{{ asset('storage/banner/slide_2.jpg') }}');">
    <h1 class="product-title">GIỎ HÀNG</h1>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-9">
            <div class="ibox">
                <div class="ibox-title">
                    <span class="pull-right">(<strong>{{ count($cart) }}</strong>) sản phẩm</span>
                    <h5>Sản phẩm trong giỏ hàng</h5>
                </div>
                @if(count($cart) > 0)
                    @foreach($cart as $id => $item)
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
                                    <tbody>
                                        <tr>
                                            <td width="90">
                                                <div class="cart-product-imitation">
                                                    @if($item['image'])
                                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" style="max-width: 100%;">
                                                    @else
                                                        <p>Chưa có hình ảnh</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="desc">
                                                <h3>
                                                    <a href="{{ route('shop.product', $item['slug']) }}" class="text-navy">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </h3>
                                                <div class="m-t-sm">
                                                    <a href="#" class="text-muted"><i class="fa fa-gift"></i> Thêm gói quà tặng</a>
                                                    |
                                                    <a href="#" class="text-muted remove-item" data-id="{{ $id }}"><i class="fa fa-trash"></i> Xóa sản phẩm</a>
                                                </div>
                                            </td>
                                            <td>
                                                @if(isset($item['discounted_price']) && $item['discounted_price'] < $item['price'])
                                                    <span style="text-decoration: line-through;">{{ number_format($item['price'], 0, ',', '.') }} đ</span><br>
                                                    <span>{{ number_format($item['discounted_price'], 0, ',', '.') }} đ</span>
                                                @else
                                                    <span>{{ number_format($item['price'], 0, ',', '.') }} đ</span>
                                                @endif
                                            </td>
                                            <td width="100">
                                                <input type="number" class="form-control update-quantity" data-id="{{ $id }}" value="{{ $item['quantity'] }}" min="1">
                                            </td>
                                            <td>
                                                <h4>{{ number_format(($item['discounted_price'] ?? $item['price']) * $item['quantity'], 0, ',', '.') }} đ</h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    <div class="ibox-content">
                        <a href="{{ route('shop.payment') }}" class="btn btn-primary pull-right"><i class="fa fa-shopping-cart"></i> Thanh toán</a>
                        <a href="{{ route('shop.home') }}" class="btn btn-white"><i class="fa fa-arrow-left"></i> Tiếp tục mua sắm</a>
                    </div>
                @else
                    <div class="ibox-content">
                        <p>Giỏ hàng của bạn hiện đang trống.</p>
                        <a href="{{ route('shop.home') }}" class="btn btn-white"><i class="fa fa-arrow-left"></i> Tiếp tục mua sắm</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Tổng kết giỏ hàng</h5>
                </div>
                <div class="ibox-content">
                    @if($originalTotal > $total)
                        <span>Tổng tiền gốc</span>
                        <h4 style="text-decoration: line-through;">{{ number_format($originalTotal, 0, ',', '.') }} đ</h4>
                        <span>Tổng sau khuyến mãi</span>
                        <h2 class="font-bold cart-total">{{ number_format($total, 0, ',', '.') }} đ</h2>
                    @else
                        <span>Tổng</span>
                        <h2 class="font-bold cart-total">{{ number_format($total, 0, ',', '.') }} đ</h2>
                    @endif
                    <hr/>
                    <div class="m-t-sm">
                        <div class="btn-group">
                            <a href="{{ route('shop.payment') }}" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Thanh toán</a>
                            <a href="{{ route('shop.home') }}" class="btn btn-white btn-sm"> Hủy</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Hỗ trợ</h5>
                </div>
                <div class="ibox-content text-center">
                    <h3><i class="fa fa-phone"></i> 0914 377808</h3>
                    <span class="small">
                        Nếu có thắc mắc về sản phẩm hãy liên hệ đến đường dây nóng này
                    </span>
                </div>
            </div>
            <div class="ibox">
                <div class="ibox-content">
                    <p class="font-bold">Có thể bạn sẽ thích</p>
                    <hr/>
                    @if($relatedProducts->isNotEmpty())
                        @foreach($relatedProducts as $related)
                            <div class="row">
                                <div class="col-4">
                                    @if($related->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $related->images->first()->image_url) }}" 
                                             alt="{{ $related->name }}" 
                                             style="max-width: 100%; height: auto;">
                                    @else
                                        <p>Chưa có hình ảnh</p>
                                    @endif
                                </div>
                                <div class="col-8">
                                    <a href="{{ route('shop.product', $related->slug) }}" class="product-name">{{ $related->name }}</a>
                                    <div class="small m-t-xs">
                                        {{ Str::limit($related->description, 30) }}
                                    </div>
                                    <div class="m-t text-right">
                                        <a href="{{ route('shop.product', $related->slug) }}" class="btn btn-xs btn-outline btn-primary">
                                            Xem chi tiết <i class="fa fa-long-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr/>
                            @endif
                        @endforeach
                    @else
                        <p>Không có sản phẩm tương tự.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif
@push('styles')
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
@push('scripts')
<script>
    $(document).ready(function() {
        $('.update-quantity').on('change', function() {
            var productId = $(this).data('id');
            var quantity = $(this).val();

            $.ajax({
                url: '{{ route("shop.cart.update") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    if (response.success) {
                        $('.cart-total').text(response.total);
                        $('.badge.bg-danger').text(response.cart_count);
                        location.reload();
                    }
                }
            });
        });

        $('.remove-item').on('click', function(e) {
            e.preventDefault();
            var productId = $(this).data('id');

            $.ajax({
                url: '{{ route("shop.cart.remove") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },
                success: function(response) {
                    if (response.success) {
                        $('.cart-total').text(response.total);
                        $('.badge.bg-danger').text(response.cart_count);
                        location.reload(); // Tải lại trang để cập nhật giao diện
                    }
                }
            });
        });

        $('#checkout-form, #checkout-sidebar-form').on('submit', function(e) {
            if (!confirm('Bạn có chắc chắn muốn thanh toán?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection