@extends('admin.layouts.master')
@section('title', 'Quản lý danh mục sản phẩm')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thêm danh mục mới</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="">
                            <div class="row">
                                <a href="{{ route('admin.categories.create') }}"
                                    class="btn btn-block btn-outline btn-primary" type="submit"><i class="fa fa-plus"></i>
                                    Thêm danh mục</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Danh sách danh mục</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Slug</th>
                                    <th>Danh mục cha</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->parent ? $category->parent->name : 'Không có' }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.categories.edit', $category->slug) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Sửa</a>
                                            <form action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST"
                                                class="delete-form" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-warning btn-sm delete-btn"><i
                                                        class="fa fa-trash"></i> Xóa</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <script>
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
                    Swal.fire({
                        title: "Bạn có chắc chắn?",
                        text: "Danh mục sẽ bị xóa vĩnh viễn!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Có, xóa ngay!",
                        cancelButtonText: "Hủy"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log("Đang xóa danh mục..."); // Kiểm tra xem hàm có chạy không
                            this.closest('form').submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection