@extends('admin.layouts.master')
@section('title', 'Thêm tin tức')
@section('content')
    <div class="container">
        <h1>Thêm bài viết mới</h1>
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>Ảnh minh họa</label>
                <input type="file" name="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label>Ngày xuất bản</label>
                <input type="datetime-local" name="published_at" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection