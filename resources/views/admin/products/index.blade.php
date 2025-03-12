@extends('admin.layouts.master')
@section('title', 'Quản lý sản phẩm')
@push('styles')
<link href="{{ asset('admin_assets/css/plugins/footable/footable.core.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="ibox-content m-b-sm border-bottom">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="product_name" class="control-label">Tên sản phẩm</label>
                        <input type="text" name="product_name" id="product_name" value placeholder="Nhập tên"
                            class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="price" class="control-label">Giá</label>
                        <input type="text" name="price" id="price" value placeholder="Giá" class="form-control">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="" class="control-label">Số lượng tồn</label>
                        <input type="text" name="stock" id="stock" value placeholder="Số lượng" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="" class="control-label">Danh mục</label>
                        <select name="categoriy_id" id="categoriy_id" class="form-control">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
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
                                    <th data-hide="phone,tablet">Số lượng</th>
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
                                        <td>{{ $product->stock }}</td>
                                        <td class="text-right">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.products.show', $product->slug) }}" class="btn btn-white btn-xs">View</a>
                                                <a href="{{ route('admin.products.edit', $product->slug) }}" class="btn btn-white btn-xs">Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script src="{{ asset('admin_assets/js/plugins/footable/footable.all.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('.footable').footable();

    });

</script>
@endpush
@endsection