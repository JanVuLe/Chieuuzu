@extends('shop.layouts.master')
@section('title', $article->title . ' - Tân Phú Hưng - Chiếu Uzu & Cói')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ $article->title }}</h1>
                <div class="mb-3 text-muted">
                    <small>
                        Người đăng: {{ $article->user ? $article->user->name : 'Ẩn danh' }} |
                        Ngày đăng: {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->format('d/m/Y') : 'Chưa xuất bản' }}
                    </small>
                </div>
                @if ($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" class="img-fluid rounded mb-4" alt="{{ $article->title }}" style="max-height: 400px; width: 100%; object-fit: cover;">
                @endif
                <div class="content">{!! $article->content !!}</div>
                <a href="{{ route('shop.news.index') }}" class="btn btn-outline-secondary mt-4">Quay lại</a>
            </div>
        </div>
    </div>

@push('styles')
    <style>
        .content {
            line-height: 1.8;
            font-size: 16px;
        }
        .content img {
            max-width: 100%;
            height: auto;
        }
    </style>
@endpush
@endsection