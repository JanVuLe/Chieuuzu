@extends('admin.layouts.master')
@section('title', 'Thông tin cá nhân')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Thông tin cá nhân</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $admin->email }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $admin->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Ảnh đại diện</label>
                            <input type="file" class="form-control-file" id="avatar" name="avatar">
                            @if($admin->avatar)
                                <img src="{{ asset('storage/' . $admin->avatar) }}" alt="Avatar" style="max-width: 100px; margin-top: 10px;">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection