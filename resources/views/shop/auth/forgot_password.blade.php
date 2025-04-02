@extends('shop.layouts.master')
@section('title', 'Quên mật khẩu')
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
                <h2 class="font-bold">Quên mật khẩu</h2>
                <p>
                    Nhập email của bạn để nhận liên kết đặt lại mật khẩu.
                </p>
                <div class="row">
                    <div class="col-lg-12">
                        <form class="m-t" role="form" method="post" action="{{ route('password.email') }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="">
                                @error('email')
                                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary block full-width m-b">Gửi liên kết đặt lại mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
</div>
@endsection