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
                                    <th data-toggle="true">Product Name</th>
                                    <th data-hide="phone">Model</th>
                                    <th data-hide="all">Description</th>
                                    <th data-hide="phone">Price</th>
                                    <th data-hide="phone,tablet">Quantity</th>
                                    <th data-hide="phone">Status</th>
                                    <th class="text-right" data-sort-ignore="true">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        Example product 1
                                    </td>
                                    <td>
                                        Model 1
                                    </td>
                                    <td>
                                        It is a long established fact that a reader will be distracted by the readable
                                        content of a page when looking at its layout. The point of using Lorem Ipsum is
                                        that it has a more-or-less normal distribution of letters, as opposed to using
                                        'Content here, content here', making it look like readable English.
                                    </td>
                                    <td>
                                        $50.00
                                    </td>
                                    <td>
                                        1000
                                    </td>
                                    <td>
                                        <span class="label label-primary">Enable</span>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <button class="btn-white btn btn-xs">View</button>
                                            <button class="btn-white btn btn-xs">Edit</button>
                                        </div>
                                    </td>
                                </tr>
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