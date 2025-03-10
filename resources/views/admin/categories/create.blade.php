@extends('admin.layouts.master')
@section('title', 'Thêm danh mục mới')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thêm danh mục mới</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên danh mục"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Danh mục cha</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">-- Không có danh mục cha --</option> <!-- Mặc định -->
                                    @if(isset($categories) && $categories->count() > 0)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary"><i
                                    class="fa fa-arrow-left"></i> Quay lại</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection