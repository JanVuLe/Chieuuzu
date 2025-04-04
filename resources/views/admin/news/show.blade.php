@extends('admin.layouts.master')
@section('title', 'Chi tiết tin tức')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="container">
        <div class="form-group">
            <label>Tiêu đề:</label>
            <p class="form-control-static">{{ $article->title }}</p>
        </div>
        <div class="form-group">
            <label>Nội dung:</label>
            <div class="form-control-static">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>
        <div class="form-group">
            <label>Ảnh minh họa:</label>
            @if ($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" style="max-width: 200px;">
            @else
                <p>Không có ảnh minh họa</p>
            @endif
        </div>
        <div class="form-group">
            <label>Ngày xuất bản:</label>
            <p class="form-control-static">
                {{ $article->published_at ? $article->published_at->format('d/m/Y H:i') : 'Chưa xuất bản' }}
            </p>
        </div>
        <div class="form-group">
            <label>Người đăng:</label>
            <p class="form-control-static">
                {{ $article->user ? $article->user->name : 'Ẩn danh' }}
            </p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-primary">Quay lại danh sách</a>
    </div>
</div>
@endsection