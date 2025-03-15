@extends('admin.layouts.master')
@section('title', 'Quản lý kho hàng')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thêm kho hàng mới</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="">
                            <div class="row">
                                <a href="{{ route('admin.warehouses.create') }}"
                                    class="btn btn-block btn-outline btn-primary" type="submit"><i class="fa fa-plus"></i>
                                    Thêm kho hàng</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Danh sách kho hàng</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên kho hàng</th>
                                    <th>Địa chỉ</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $warehouse->id }}</td>
                                        <td>{{ $warehouse->name }}</td>
                                        <td>{{ $warehouse->location }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.warehouses.show', $warehouse) }}" class="btn btn-white btn-sm"><i class="fa fa-search"></i>Xem</a>
                                            <a href="{{ route('admin.warehouses.edit', $warehouse) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Sửa</a>
                                            <form action="{{ route('admin.warehouses.destroy', $warehouse->id) }}" method="POST" style="display: inline-block;" 
                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa kho hàng này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
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
                            console.log("Đang xóa danh mục...");
                            this.closest('form').submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection