@extends('admin.layouts.master')
@push('styles')
<link href="{{ asset('admin_assets/switchery-0.8.2/dist/switchery.min.css') }}" rel="stylesheet">
@endpush
@section('title', 'Quản lý người dùng')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Quyền hạn</th>
                                        <th>Trạng thái</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="gradeU">
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <input type="checkbox" class="toggle-status" data-id="{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                    class="btn btn-info btn-sm">Xem</a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm">Sửa</a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Email</th>
                                        <th>Tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Quyền hạn</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('admin_assets/switchery-0.8.2/dist/switchery.min.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let elems = document.querySelectorAll('.toggle-status');
                elems.forEach(function (el) {
                    new Switchery(el, { color: '#1AB394', secondaryColor: '#ED5565' });
                });

                document.querySelectorAll('.toggle-status').forEach(function (el) {
                el.addEventListener('change', function () {
                    let userId = this.getAttribute('data-id'); // Lấy ID user
                    let isActive = this.checked ? 1 : 0; // Kiểm tra trạng thái

                    fetch('/admin/users/toggle-status/' + userId, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ is_active: isActive })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Cập nhật trạng thái thành công');
                        } else {
                            console.error('Lỗi cập nhật trạng thái');
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
                });
            });
            });
        </script>
    @endpush
@endsection