@extends('admin.layouts.master')
@section('title', 'Tạo Chương Trình Khuyến Mãi')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tạo Khuyến Mãi Mới</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.discounts.store') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="name">Tên Khuyến Mãi</label>
                                <input type="text" name="name" class="form-control" required placeholder="Nhập tên khuyến mãi">
                            </div>

                            <div class="form-group">
                                <label for="percentage">Phần Trăm Giảm Giá (%)</label>
                                <input type="number" name="percentage" class="form-control" required step="0.01" min="0" max="100" placeholder="Nhập phần trăm giảm">
                            </div>

                            <div class="form-group">
                                <label for="start_date">Ngày Bắt Đầu</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="end_date">Ngày Kết Thúc</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="status">Trạng Thái</label>
                                <select name="status" class="form-control">
                                    <option value="active">Hoạt động</option>
                                    <option value="inactive">Không hoạt động</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu Khuyến Mãi</button>
                            <a href="{{ route('admin.discounts.index') }}" class="btn btn-danger">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
