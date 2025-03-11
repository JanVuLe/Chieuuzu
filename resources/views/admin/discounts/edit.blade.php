@extends('admin.layouts.master')
@section('title', 'Chỉnh sửa khuyến mãi')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chỉnh sửa khuyến mãi</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Tên khuyến mãi:</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $discount->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="percentage">Phần trăm giảm giá:</label>
                                <input type="number" name="percentage" class="form-control" value="{{ old('percentage', $discount->percentage) }}" step="0.01" min="0" max="100" required>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Ngày bắt đầu:</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $discount->start_date ? $discount->start_date->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Ngày kết thúc:</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $discount->end_date ? $discount->end_date->format('Y-m-d') : '') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Trạng thái:</label>
                                <select name="status" class="form-control">
                                    <option value="active" {{ $discount->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="inactive" {{ $discount->status == 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
