@extends('shop.layouts.master')
@section('title', 'Đặt lại mật khẩu')

@push('styles')
<style>
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

#wrapper {
    flex: 1;
    display: flex;
    flex-direction: column;
}

#page-wrapper {
    flex: 1;
}

footer {
    margin-top: auto;
    background-color: #f8f9fa;
    padding: 10px 0;
    text-align: center;
}
</style>
@endpush

@section('content')
<div class="passwordBox animated fadeInDown">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">
                <h2 class="font-bold">Đặt lại mật khẩu</h2>
                <p>Nhập mật khẩu mới của bạn.</p>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" role="form" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email', $email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới" required>
                                @error('password')
                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Xác nhận mật khẩu" required>
                            </div>

                            <button type="submit" class="btn btn-primary block full-width m-b">Đặt lại mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
</div>
@endsection