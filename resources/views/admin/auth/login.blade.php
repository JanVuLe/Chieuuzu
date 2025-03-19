<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }} " rel="stylesheet">

    <link href="{{ asset('assets/css/animate.css') }} " rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }} " rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">Chiếu Uzu</h1>

            </div>
            <h3>Tân Phú Hưng</h3>
            <p>Đăng nhập.</p>
            @include('admin.alert')
            <form method="post" class="m-t" role="form" action="{{ route('admin.login.store') }}">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Đăng nhập</button>

                <a href="#"><small>Quên mật khẩu?</small></a>
                @csrf
            </form>
            <p class="m-t"> <small>Trang chủ admin &copy; 2025</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }} "></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }} "></script>

</body>

</html>