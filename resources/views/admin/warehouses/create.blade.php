@extends('admin.layouts.master')
@section('title', 'Thêm kho hàng mới')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thêm kho hàng mới</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.warehouses.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên kho hàng</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên kho hàng" required>
                            </div>
                            <div class="form-group">
                                <label for="location">Địa chỉ kho hàng</label>
                                <input type="text" name="location" class="form-control" placeholder="Nhập địa chỉ kho hàng" required>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
