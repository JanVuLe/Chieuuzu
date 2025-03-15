@extends('admin.layouts.master')
@section('title', 'Thêm sản phẩm')
@push('styles')
    <link href="{{ asset('admin_assets/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thêm sản phẩm</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên sản phẩm:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Mô tả:</label>
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="price">Giá:</label>
                                <input type="number" name="price" class="form-control" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Danh mục:</label>
                                <select name="category_id" class="form-control">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="discount_id">Khuyến mãi (nếu có):</label>
                                <select name="discount_id" class="form-control">
                                    <option value="">Không có</option>
                                    @foreach($discounts as $discount)
                                        <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="images">Hình ảnh sản phẩm</label>
                                <input type="file" name="images[]" multiple class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection