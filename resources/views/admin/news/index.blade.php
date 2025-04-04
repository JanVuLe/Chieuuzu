@extends('admin.layouts.master')
@section('title', 'Danh sách tin tức')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="container">
        <div class="row mb-3">
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary mb-3">Thêm bài viết</a>
        </div>
        <div class="row" style="padding-top: 10px;">
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
                                <form action="{{ route('admin.news.destroy', $article->slug) }}" method="POST" class="delete-form" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm sweetalert-delete">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $news->links() }}
    </div>
</div>
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/sweetalert2/sweetalert2.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.sweetalert-delete').click(function (e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của nút

            const form = $(this).closest('form'); // Lấy form chứa nút "Xóa"

            Swal.fire({
                title: "Bạn có chắc chắn không?",
                text: "Bạn sẽ không thể khôi phục lại bài viết này!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonColor: "#d33",
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Gửi form nếu người dùng xác nhận
                }
            });
        });
    });
</script>
@if(session('success'))
    <script>
        Swal.fire({
            title: "Thành công!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            title: "Lỗi!",
            text: "{{ session('error') }}",
            icon: "error",
            confirmButtonText: "Thử lại"
        });
    </script>
@endif
@endpush
@endsection