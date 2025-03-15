@extends('admin.layouts.master')
@section('title', 'Quản lý sản phẩm')

@push('styles')
<link href="{{ asset('admin_assets/css/plugins/footable/footable.core.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <!-- Form lọc sản phẩm -->
    <form action="{{ route('admin.products.index') }}" method="GET">
        <div class="ibox-content m-b-sm border-bottom">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="product_name" class="control-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" id="product_name" value="{{ request('product_name') }}" placeholder="Nhập tên" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="price" class="control-label">Giá tối đa</label>
                        <input type="number" name="price" id="price" value="{{ request('price') }}" placeholder="Giá" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="stock" class="control-label">Số lượng</label>
                        <input type="number" name="stock" id="stock" value="{{ request('stock') }}" placeholder="Số lượng" class="form-control">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="category_id" class="control-label">Danh mục</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Tất cả</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i>  Lọc</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                        <thead>
                            <tr>
                                <th data-toggle="true">Tên sản phẩm</th>
                                <th data-hide="phone">Danh mục</th>
                                <th data-hide="all">Mô tả</th>
                                <th data-hide="phone">Giá</th>
                                <th class="text-right" data-sort-ignore="true">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'Không có' }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ number_format($product->price, 0, ',', '.') }} VND</td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.products.show', $product->slug) }}" class="btn btn-white btn-xs">View</a>
                                            <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-white btn-xs">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->slug) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-white btn-xs">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('admin_assets/js/plugins/footable/footable.all.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: "Thành công!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            title: "Lỗi!",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonText: "Thử lại"
        });
    </script>
@endif
<script>
    $(document).ready(function() {
        $('.footable').footable();
    });

    document.querySelectorAll('#product_name, #price, #stock, #category_id').forEach(input => {
        input.addEventListener('change', function () {
            this.form.submit();
        });
    });
</script>
@endpush
@endsection
