@extends('admin.layouts.master')
@push('styles')
    <link href="{{ asset('assets/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
@endpush
@section('title', 'Chỉnh sửa người dùng')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Chỉnh sửa người dùng</h5>
                    </div>
                    <div class="ibox-content">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="{{ $user->phone ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label>Quyền hạn</label>
                                <div>
                                    <div class="col-sm-12">
                                        <div class="i-checks"><input type="radio" name="role" value="admin" {{ $user->role == 'admin' ? 'checked' : '' }}> <i></i> Quản trị</div>
                                        <div class="i-checks"><input type="radio" name="role" value="user" {{ $user->role == 'user' ? 'checked' : '' }}></i>Khách hàng</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <div class="col-sm-12">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                            <span class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="avatar" />
                                        </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
                                    <img id="avatarPreview"
                                        src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/avatars/default-avatar.jpg') }}"
                                        class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                            </div>

                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-default">Hủy</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
        <script>
            document.getElementById("avatarInput").addEventListener("change", function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById("avatarPreview").src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection