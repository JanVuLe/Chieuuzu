@extends('shop.layouts.master')
@section('title', 'Hồ sơ cá nhân')

@push('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .profile-header h1 {
        color: #007bff;
        font-size: 28px;
        font-weight: bold;
    }

    .profile-form .form-group {
        margin-bottom: 20px;
    }

    .profile-form label {
        font-weight: 600;
        color: #333;
    }

    .profile-form input {
        border-radius: 5px;
    }

    .btn-save {
        background: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        transition: background 0.3s ease;
    }

    .btn-save:hover {
        background: #0056b3;
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <h1>Hồ sơ cá nhân</h1>
        <p>Cập nhật thông tin cá nhân của bạn tại đây</p>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('shop.profile.update') }}" method="POST" class="profile-form">
        @csrf
        <div class="form-group">
            <label for="name">Họ và tên</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="avatar">Ảnh đại diện</label>
            <input type="file" class="form-control-file" id="avatar" name="avatar">
            @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="max-width: 100px; margin-top: 10px;">
            @endif
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
        </div>

        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
            @error('phone')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}">
            @error('address')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-save">Lưu thay đổi</button>
        </div>
    </form>
</div>
@endsection