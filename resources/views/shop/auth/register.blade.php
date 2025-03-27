@extends('shop.layouts.master')

@section('title', 'Đăng ký')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Đăng ký</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" action="{{ route('shop.register.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" class="form-control" id="name" name="name">
                            @if ($errors->has('name'))
                                <div class="alert alert-danger">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            @if ($errors->has('email'))
                                <div class="alert alert-danger">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                            @if ($errors->has('phone'))
                                <div class="alert alert-danger">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="password" name="password">
                                <span class="toggle-password">
                                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                <div class="alert alert-danger">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                <span class="toggle-password">
                                    <i class="bi bi-eye-slash" id="togglePasswordConfirmIcon"></i>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                        <div class="text-center mt-3">
                            <p>Đã có tài khoản? <a href="{{ route('shop.login') }}">Đăng nhập ngay</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        // Chức năng hiển thị/ẩn mật khẩu cho ô "Mật khẩu"
        const togglePassword = document.querySelector('#togglePasswordIcon').parentElement;
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye-slash');
            icon.classList.toggle('bi-eye');
        });

        // Chức năng hiển thị/ẩn mật khẩu cho ô "Xác nhận mật khẩu"
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirmIcon').parentElement;
        const passwordConfirmInput = document.querySelector('#password_confirmation');

        togglePasswordConfirm.addEventListener('click', function () {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye-slash');
            icon.classList.toggle('bi-eye');
        });
    </script>
@endpush

@push('styles')
    <style>
        .password-wrapper {
            display: flex;
            align-items: center;
            position: relative;
        }
        .password-wrapper .form-control {
            flex: 1;
        }
        .toggle-password {
            margin-left: -2.5rem; /* Đảm bảo biểu tượng nằm trong input */
            cursor: pointer;
        }
        .toggle-password i {
            font-size: 1.2rem;
            color: #6c757d;
            transition: color 0.3s ease;
        }
        .toggle-password:hover i {
            color: #007bff;
        }
    </style>
@endpush