@extends('shop.layouts.master')
@section('title', 'TIN TỨC - Tân Phú Hưng - Chiếu Uzu & Cói')
@section('content')
    <div class="news-header" style="background-image: url('{{ asset('storage/banner/slide_2.jpg') }}');">
        <h1 class="news-title">TIN TỨC</h1>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar">
                        <div class="sidebar-title">
                            <h4>Danh mục sản phẩm</h4>
                        </div>
                        <ul class="list-unstyled">
                            @foreach ($categories as $category)
                                <li class="mb-2 category-box">
                                    <a href="{{ route('shop.category', $category->slug) }}" class="text-decoration-none text-dark">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    @forelse ($news as $article)
                        <div class="col-md-12 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="row g-0">
                                    <!-- Hình ảnh -->
                                    @if ($article->image)
                                        <div class="col-md-3">
                                            <img src="{{ asset('storage/' . $article->image) }}" class="img-fluid rounded-start" alt="{{ $article->title }}" style="height: 150px; object-fit: cover;">
                                        </div>
                                    @endif
                                    <!-- Thông tin -->
                                    <div class="col-md-{{ $article->image ? '8' : '12' }}">
                                        <div class="card-body d-flex flex-column h-100">
                                            <!-- Tiêu đề -->
                                            <h3 class="card-title mb-2">
                                                <a href="{{ route('shop.news.show', $article->slug) }}" class="text-dark text-decoration-none">{{ $article->title }}</a>
                                            </h3>
                                            <!-- Nội dung mô tả -->
                                            <p class="card-text text-muted flex-grow-1">{{ \Str::limit(strip_tags($article->content), 150) }}</p>
                                            <!-- Người đăng và thời gian-->
                                            <div class="mt-auto text-end">
                                                <small class="text-muted">
                                                    Người đăng: {{ $article->user ? $article->user->name : 'Ẩn danh' }} |
                                                    Ngày: {{ $article->published_at ? $article->published_at->format('d/m/Y') : 'Chưa xuất bản' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>Chưa có tin tức nào.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $news->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@push('styles')
<link rel="stylesheet" href="{{ asset('css/shop.css') }}">
<style>
    .news-header {
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background-size: cover;
        background-position: center;
    }

    .news-header::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255, 214, 103, 0.6); /* Lớp phủ vàng nhẹ */
    }

    .news-title {
        position: relative;
        background: #fff;
        padding: 10px 20px;
        border: 2px solid #8B0000;
        color: #8B0000;
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-title:hover {
        text-decoration: underline;
        color: #0056b3; /* Màu xanh đậm khi hover */
    }
    .card-body {
        padding: 1.5rem;
    }
    .sidebar {
        background-color: #f8f9fa;
        padding: 20px;
        padding-top: 0px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    .sidebar-title {
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px 1px 20px;
        position: relative;
        font-family: 'Quicksand', sans-serif;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        background: #186f4c;
        min-width: 223px;
        margin-left: -30px;
        margin-right: -20px;
        border-radius: 5px 5px 0px 0px;
    }
    .sidebar-title h4::after{
        content: "";
        height: 1px;
        width: 1px;
        border-style: solid;
        border-width: 5px;
        position: absolute;
        bottom: -10px;
        left: 0;
        border-color: #186f4c #186f4c transparent transparent;
    }
    .sidebar ul li a:hover {
        color: #0056b3;
    }
    .category-box {
        border-bottom: 1px solid;
        padding: 10px 0;
        font-size: 16px;
        font-weight: 500;
    }
</style>
@endpush
@endsection