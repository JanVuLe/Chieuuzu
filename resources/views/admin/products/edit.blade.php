@extends('admin.layouts.master')
@section('title', 'Cập nhật sản phẩm')
@push('styles')
<link href="{{ asset('admin_assets/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <form action="{{ route('admin.products.update', $product->slug) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Thông tin sản phẩm</a></li>
                            <li><a data-toggle="tab" href="#tab-2"> Dữ liệu</a></li>
                            <li><a data-toggle="tab" href="#tab-3"> Khuyến mãi</a></li>
                            <li><a data-toggle="tab" href="#tab-4"> Hình ảnh</a></li>
                        </ul>
                        <div class="tab-content">
                            {{-- TAB 1: Thông tin sản phẩm --}}
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <fieldset class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Tên sản phẩm:</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Giá:</label>
                                            <div class="col-sm-9">
                                                <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Mô tả:</label>
                                            <div class="col-sm-9">
                                                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            {{-- TAB 2: Dữ liệu --}}
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Slug:</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="slug" class="form-control" value="{{ $product->slug }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Danh mục:</label>
                                            <div class="col-sm-9">
                                                <select name="category_id" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 3: Khuyến mãi --}}
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Mã khuyến mãi</th>
                                                    <th>Tên khuyến mãi</th>
                                                    <th>Phần trăm (%)</th>
                                                    <th>Ngày bắt đầu</th>
                                                    <th>Ngày kết thúc</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product->discounts as $discount)
                                                    <tr id="discountRow_{{ $discount->id }}">
                                                        <td>{{ $discount->id }}</td>
                                                        <td>{{ $discount->name }}</td>
                                                        <td>{{ $discount->percentage }}%</td>
                                                        <td>{{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }}</td>
                                                        <td>{{ $discount->status }}</td>
                                                        <td>
                                                            <button type="button" class="btn btn-white delete-discount" 
                                                                    data-product-id="{{ $product->id }}" 
                                                                    data-discount-id="{{ $discount->id }}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>                                                   
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($product->discounts->isEmpty())
                                            <p class="text-center">Sản phẩm này chưa có khuyến mãi nào.</p>
                                        @endif
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary" id="showFormBtn">
                                            Thêm khuyến mãi
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 4: Hình ảnh --}}
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Hình ảnh</th>
                                                    <th>Đường dẫn</th>
                                                    <th class="text-center">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($product->images as $image)
                                                    <tr>
                                                        <td><img src="{{ asset('storage/' . $image->image_url) }}" width="100"></td>
                                                        <td>{{ $image->image_url }}</td>
                                                        <td class="text-center">
                                                            <form action="{{ route('admin.product_images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa hình ảnh này?');">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if ($product->images->isEmpty())
                                            <p class="text-center">Chưa có hình ảnh nào cho sản phẩm này.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Nút Cập Nhật --}}
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-white">Trở Về</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Form applyDiscount --}}
        <div class="row" id="discountForm" style="display: none;">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h4>Chọn giảm giá cho sản phẩm</h4>
                    </div>
                    <div class="ibox-content">
                        <form id="applyDiscountForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                            <div class="mb-3">
                                <label for="discountSelect" class="form-label">Chọn Giảm Giá</label>
                                <select class="form-select" name="discount_id" id="discountSelect">
                                    <option value="">-- Chọn giảm giá --</option>
                                    @foreach($discounts as $discount)
                                        <option value="{{ $discount->id }}">{{ $discount->name }} - {{ $discount->percentage }}%</option>
                                    @endforeach
                                </select>
                            </div>
                
                            <button type="submit" class="btn btn-success">Áp Dụng</button>
                            <button type="button" class="btn btn-secondary" id="hideFormBtn">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>g
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('admin_assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
    $(document).ready(function(){
        $("#showFormBtn").click(function(){
            $("#discountForm").slideDown();
        });

        $("#hideFormBtn").click(function(){
            $("#discountForm").slideUp();
        });

        $("#applyDiscountForm").submit(function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('admin.products.applyDiscount') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response){
                    alert(response.message);
                    $("#discountForm").slideUp();
                },
                error: function(xhr){
                    alert("Có lỗi xảy ra! Vui lòng thử lại.");
                }
            });
        });

        $(".delete-discount").click(function() {
            if (!confirm("Bạn có chắc chắn muốn xóa khuyến mãi?")) return;

            let productId = $(this).data("product-id");
            let discountId = $(this).data("discount-id");
            let row = $("#discountRow_" + discountId);
            let url = `/admin/products/${productId}/discounts/${discountId}`;

            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    alert(response.message);
                    row.remove();
                    location.reload();
                },
                error: function(xhr) {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                }
            });
        });
    });
</script>
@endpush    
@endsection
