@extends('admin.layouts.master')
@section('title', 'Thông tin người dùng')
@section('content')
    <div class="wrapper wrapper-content">
        <div class="row animated fadeInRight">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thông tin</h5>
                    </div>
                    <div>
                        <div class="ibox-content no-padding border-left-right">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" 
                                 alt="Avatar" class="img-responsive">
                        </div>
                        <div class="ibox-content profile-content">
                            <h4>{{ $user->name }}</h4>
                            <h5>Chi tiết</h5>
                            <p>
                                <i class="fa fa-envelope"></i>
                                {{ $user->email }}
                            </p>
                            <p>
                                <i class="fa fa-phone"></i>
                                {{ $user->phone }}
                            </p>
                            <p>
                                <i class="fa fa-map-marker"></i>
                                {{ $user->address }}
                            </p>
                            <p>
                                {{ $user->role === 'admin' ? 'Quản trị viên' : 'Khách hàng' }}
                            </p>
                            <p>
                                <strong>Trạng thái:</strong> 
                                <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $user->is_active ? 'Hoạt động' : 'Đã khóa' }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Quay lại</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Sửa</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection