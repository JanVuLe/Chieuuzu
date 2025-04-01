@extends('admin.layouts.master')
@section('title', 'Danh sách tin tức')
@section('content')
    <div class="container">
        <h1>Danh sách tin tức</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary mb-3">Thêm bài viết</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Người đăng</th>
                    <th>Ngày đăng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->user ? $article->user->name : 'Ẩn danh' }}</td>
                        <td>{{ $article->published_at ? $article->published_at->format('d/m/Y') : 'Chưa xuất bản' }}</td>
                        <td>
                            <a href="{{ route('admin.news.show', $article->slug) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('admin.news.edit', $article->slug) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('admin.news.destroy', $article->slug) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $news->links() }}
    </div>
@endsection