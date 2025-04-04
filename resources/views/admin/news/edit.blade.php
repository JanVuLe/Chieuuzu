@extends('admin.layouts.master')
@section('title', 'Sửa tin tức')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="container">
        <form action="{{ route('admin.news.update', $article->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Tiêu đề</label>
                <input type="text" name="title" class="form-control" value="{{ $article->title }}" required>
            </div>
            <div class="form-group">
                <label>Nội dung</label>
                <textarea name="content" class="form-control" rows="5" required>{{ $article->content }}</textarea>
            </div>
            <div class="form-group">
                <label>Ảnh minh họa</label>
                @if ($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="max-width: 200px;">
                @endif
                <input type="file" name="image" class="form-control-file">
            </div>
            <div class="form-group">
                <label>Ngày xuất bản</label>
                <input type="datetime-local" name="published_at" class="form-control" value="{{ $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '' }}">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
</div>
@endsection