@extends('admin.layouts.master')
@section('title', 'Quản lý chương trình khuyến mãi')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thêm chương trình khuyến mãi</h5>
                    </div>
                    <div class="ibox-content">
                        <a href="{{ route('admin.discounts.create') }}" class="btn btn-block btn-outline btn-primary">
                            <i class="fa fa-plus"></i> Thêm khuyến mãi
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Danh sách khuyến mãi</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên khuyến mãi</th>
                                        <th>Phần trăm</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discounts as $discount)
                                        <tr>
                                            <td>{{ $discount->id }}</td>
                                            <td>{{ $discount->name }}</td>
                                            <td>{{ $discount->percentage }}%</td>
                                            <td>{{ \Carbon\Carbon::parse($discount->start_date)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($discount->end_date)->format('d-m-Y') }}</td>
                                            <td class="text-center">
                                                @if ($discount->status == 'active')
                                                    <span class="badge badge-success">Hoạt động</span>
                                                @else
                                                    <span class="badge badge-secondary">Không hoạt động</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.discounts.edit', $discount->slug) }}" class="btn btn-info btn-sm">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a>
                                                <form action="{{ route('admin.discounts.destroy', $discount->slug) }}" method="POST" class="delete-form" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-warning btn-sm delete-btn">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $discounts->links() }}
                        </div>
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
                        text: "Khuyến mãi sẽ bị xóa vĩnh viễn!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Có, xóa ngay!",
                        cancelButtonText: "Hủy"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log("Đang xóa khuyến mãi..."); // Debug
                            this.closest('form').submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
