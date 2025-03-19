@extends('shop.layouts.master')
@section('title', 'Thanh toán')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Thanh toán đơn hàng</h5>
                </div>
                <div class="ibox-content">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-info">1. Thông tin</a></li>
                        <li><a data-toggle="tab" href="#tab-payment">2. Thanh toán</a></li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab 1: Thông tin -->
                        <div id="tab-info" class="tab-pane fade in active">
                            <div class="row m-t-md">
                                <div class="col-md-6">
                                    <h3>Thông tin đơn hàng</h3>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng</th>
                                                <th>Giá</th>
                                                <th>Tổng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart as $item)
                                                <tr>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td>{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                                    <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} đ</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <h4>Tổng cộng: {{ number_format($total, 0, ',', '.') }} đ</h4>
                                </div>
                                <div class="col-md-6">
                                    <h3>Thông tin người nhận</h3>
                                    <form>
                                        <div class="form-group">
                                            <label>Họ và tên</label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Địa chỉ</label>
                                            <input type="text" class="form-control" placeholder="Nhập địa chỉ giao hàng">
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control" placeholder="Nhập số điện thoại">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="text-right m-t-md">
                                <a href="#tab-payment" class="btn btn-primary" data-toggle="tab">Tiếp tục <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>

                        <!-- Tab 2: Thanh toán -->
                        <div id="tab-payment" class="tab-pane fade">
                            <div class="row m-t-md">
                                <div class="col-md-12">
                                    <h3>Phương thức thanh toán</h3>
                                    <form action="{{ route('shop.cart.checkout') }}" method="POST" id="payment-form">
                                        @csrf
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" name="payment_method" value="cod" checked> Thanh toán khi nhận hàng (COD)
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" name="payment_method" value="bank"> Chuyển khoản ngân hàng
                                            </label>
                                            <p class="text-muted small m-t-xs">Vui lòng chuyển khoản đến: Ngân hàng ABC - STK: 123456789 - Chủ TK: Tân Phú Hưng</p>
                                        </div>
                                        <div class="text-right m-t-md">
                                            <a href="#tab-info" class="btn btn-white" data-toggle="tab"><i class="fa fa-arrow-left"></i> Quay lại</a>
                                            <button type="submit" class="btn btn-primary">Xác nhận thanh toán <i class="fa fa-check"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#payment-form').on('submit', function(e) {
            if (!confirm('Bạn có chắc chắn muốn xác nhận thanh toán?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection