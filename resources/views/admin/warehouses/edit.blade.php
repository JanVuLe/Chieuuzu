@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa kho hàng')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chỉnh sửa kho hàng</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.warehouses.update', $warehouse->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name">Tên kho hàng</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $warehouse->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label for="location">Địa chỉ kho hàng</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', $warehouse->location) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cập nhật</button>
                            <a href="{{ route('admin.warehouses.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
