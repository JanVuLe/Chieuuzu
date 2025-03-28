@extends('shop.layouts.master')
@section('title', 'Thanh toán')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endpush
@section('content')
<div class="product-detail-header" style="background-image: url('{{ asset('storage/banner/slide_2.jpg') }}');">
    <h1 class="product-title">THANH TOÁN HÓA ĐƠN</h1>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Thanh toán đơn hàng</h5>
                </div>
                <div class="ibox-content">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-info">1. Thông tin</a></li>
                        <li><a data-toggle="tab" href="#tab-payment">2. Thanh toán</a></li>
                    </ul>

                    <div class="tab-content">
                        <!-- Tab 1: Thông tin -->
                        <div id="tab-info" class="tab-pane fade active in">
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
                                    <form id="shipping-form">
                                        <div class="form-group">
                                            <label>Họ và tên</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->name ?? 'Chưa có tên' }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Tỉnh/Thành phố</label>
                                            <select name="province" id="province" class="form-control searchable-select">
                                                <option value="">Chọn tỉnh/thành phố</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Quận/Huyện</label>
                                            <select name="district" id="district" class="form-control searchable-select" disabled>
                                                <option value="">Chọn quận/huyện</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Phường/Xã</label>
                                            <select name="ward" id="ward" class="form-control searchable-select" disabled>
                                                <option value="">Chọn phường/xã</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Địa chỉ chi tiết</label>
                                            <input type="text" name="street" id="street" class="form-control" placeholder="Số nhà, tên đường" value="{{ auth()->user()->address ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control" value="{{ auth()->user()->phone ?? 'Chưa có số điện thoại' }}" readonly>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="text-right m-t-md">
                                <a href="#tab-payment" class="btn btn-primary next-tab" data-target="#tab-payment">
                                    Tiếp tục <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Tab 2: Thanh toán -->
                        <div id="tab-payment" class="tab-pane fade">
                            <div class="row m-t-md">
                                <div class="col-md-12">
                                    <h3>Phương thức thanh toán</h3>
                                    <form action="{{ route('shop.cart.checkout') }}" method="POST" id="payment-form">
                                        @csrf
                                        <input type="hidden" name="province" id="province_input">
                                        <input type="hidden" name="district" id="district_input">
                                        <input type="hidden" name="ward" id="ward_input">
                                        <input type="hidden" name="street" id="street_input">
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" name="payment_method" value="cash_on_delivery" checked> Thanh toán khi nhận hàng (COD)
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                <input type="radio" name="payment_method" value="bank_transfer"> Chuyển khoản ngân hàng
                                            </label>
                                            <p class="text-muted small m-t-xs">Vui lòng chuyển khoản đến: Ngân hàng ABC - STK: 123456789 - Chủ TK: Tân Phú Hưng</p>
                                        </div>
                                        <div class="text-right m-t-md">
                                            <a href="#tab-info" class="btn btn-white prev-tab" data-target="#tab-info">
                                                <i class="fa fa-arrow-left"></i> Quay lại
                                            </a>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Khởi tạo Select2 cho các dropdown
        $('.searchable-select').select2({
            placeholder: $(this).find('option:first').text(),
            allowClear: true,
            width: '100%',
        });
        $('.searchable-select').select2({
            placeholder: 'Tìm kiếm...',
            allowClear: true,
            width: '100%',
        });
        // Lấy danh sách tỉnh/thành phố khi trang tải
        fetch('/api/provinces')
            .then(response => response.json())
            .then(data => {
                const provinceSelect = $('#province');
                data.forEach(province => {
                    provinceSelect.append(`<option value="${province.name}">${province.name}</option>`);
                });
            });

        // Khi chọn tỉnh, lấy quận/huyện
        $('#province').on('change', function() {
            const provinceName = $(this).val();
            const districtSelect = $('#district');
            districtSelect.prop('disabled', true).html('<option value="">Chọn quận/huyện</option>');
            $('#ward').prop('disabled', true).html('<option value="">Chọn phường/xã</option>');

            if (provinceName) {
                fetch(`/api/districts?province_code=${provinceName}`)
                    .then(response => response.json())
                    .then(data => {
                        districtSelect.prop('disabled', false);
                        data.forEach(district => {
                            districtSelect.append(`<option value="${district.name}">${district.name}</option>`);
                        });
                    });
            }
        });

        // Khi chọn quận/huyện, lấy phường/xã
        $('#district').on('change', function() {
            const districtName = $(this).val();
            const wardSelect = $('#ward');
            wardSelect.prop('disabled', true).html('<option value="">Chọn phường/xã</option>');

            if (districtName) {
                fetch(`/api/wards?district_code=${districtName}`)
                    .then(response => response.json())
                    .then(data => {
                        wardSelect.prop('disabled', false);
                        data.forEach(ward => {
                            wardSelect.append(`<option value="${ward.name}">${ward.name}</option>`);
                        });
                    });
            }
        });

        // Khi submit form, gán giá trị vào các input hidden
        $('#payment-form').on('submit', function(e) {
            if (!confirm('Bạn có chắc chắn muốn xác nhận thanh toán?')) {
                e.preventDefault();
                return;
            }

            $('#province_input').val($('#province').val());
            $('#district_input').val($('#district').val());
            $('#ward_input').val($('#ward').val());
            $('#street_input').val($('#street').val());
        });

        // Khi nhấn nút "Tiếp tục", chuyển sang tab 2
        $('.next-tab').on('click', function(e) {
            e.preventDefault();
            const target = $(this).data('target');

            $('.nav-tabs li').removeClass('active');
            $('.nav-tabs li:nth-child(2)').addClass('active');

            $('.tab-pane').removeClass('active in'); 
            $(target).addClass('active in');
        });

        // Khi nhấn nút "Quay lại", chuyển về tab 1
        $('.prev-tab').on('click', function(e) {
            e.preventDefault();
            const target = $(this).data('target');

            $('.nav-tabs li').removeClass('active'); 
            $('.nav-tabs li:nth-child(1)').addClass('active');

            $('.tab-pane').removeClass('active in');
            $(target).addClass('active in');
        });
    });
</script>
@endpush
@endsection