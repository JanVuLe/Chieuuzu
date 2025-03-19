@extends('admin.layouts.master')
@push('styles')
    <link href="{{ asset('assets/switchery-0.8.2/dist/switchery.min.css') }}" rel="stylesheet">
@endpush
@section('title', 'Quản lý người dùng')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tìm kiếm người dùng</h5>
                    </div>
                    <div class="ibox-content">
                        <form role="form">
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="text" placeholder="Nhập email hoặc tên người dùng" id="search"
                                        name="search" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success btn-block" type="submit"><i class="fa fa-search"></i> Tìm
                                        kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thêm người dùng mới</h5>
                    </div>
                    <div class="ibox-content">
                        <form role="form">
                            <div class="row">
                                <a class="btn btn-block btn-outline btn-primary" type="submit"
                                    href="{{ route('admin.users.create') }}"><i class="fa fa-plus"></i> Thêm người dùng</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="gradeU">
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td class="text-center">
                                                <input type="checkbox" class="toggle-status" data-id="{{ $user->id }}" {{ $user->is_active ? 'checked' : '' }}>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.users.show', $user->id) }}"
                                                    class="btn btn-info btn-sm"><i class="fa fa-eye"></i> Xem</a>
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Sửa</a>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-delete"><i
                                                            class="fa fa-trash"></i> Xóa</button>
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
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Hành động</th>
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
        <script src="{{ asset('assets/switchery-0.8.2/dist/switchery.min.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let elems = document.querySelectorAll('.toggle-status');
                elems.forEach(function (el) {
                    new Switchery(el, { color: '#1AB394', secondaryColor: '#ED5565' });
                });

                document.querySelectorAll('.toggle-status').forEach(function (el) {
                    el.addEventListener('change', function () {
                        let userId = this.getAttribute('data-id');
                        let isActive = this.checked ? 1 : 0;

                        let url = "{{ route('admin.users.toggle-status', ':id') }}".replace(':id', userId);
                        fetch(url, {
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

                                let parent = el.parentNode;
                                parent.innerHTML = parent.innerHTML; // Reset lại input
                                new Switchery(el, { color: '#1AB394', secondaryColor: '#ED5565' });
                            })
                            .catch(error => console.error('Lỗi:', error));
                    });
                });
            });
        </script>
    @endpush
@endsection