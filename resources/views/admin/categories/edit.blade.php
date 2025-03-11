@extends('admin.layouts.master')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Chỉnh sửa danh mục</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('admin.categories.update', $category->slug) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="parent_id">Danh mục cha</label>
                            <select name="parent_id" class="form-control">
                                <option value="">Không có danh mục cha</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Cập nhật</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
