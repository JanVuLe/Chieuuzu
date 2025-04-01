@push('styles')
<style>
    .breadcrumb-wrapper {
        background-color: #f8f8f8;
        padding: 5px 0;
        border-bottom: 1px solid #e7eaec;
    }
    .breadcrumb {
        background-color: transparent;
        margin-bottom: 0;
        padding: 5px 15px;
        font-size: 14px;
    }
    .breadcrumb li {
        display: inline-block;
    }
    .breadcrumb li a {
        color: #676a6c;
        text-decoration: none;
    }
    .breadcrumb li a:hover {
        color: #1ab394;
        text-decoration: underline;
    }
    .breadcrumb li.active {
        color: #1ab394;
    }
    .breadcrumb li + li:before {
        content: ">";
        padding: 0 5px;
        color: #676a6c;
    }
</style>
@endpush
<header>
    <div class="bg-primary text-white py-1">
        <marquee behavior="scroll" direction="left">
            📞 Hotline: <strong>0914 377808</strong> | ✉️ Email: <strong>tanchaulongap@gmail.com</strong> | 🛍️ Tân Phú Hưng - Chiếu Uzu & Cói - Hàng thủ công mỹ nghệ
        </marquee>
    </div>
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <i class="fa fa-reorder"></i>
            </button>
            <div class="navbar-brand">
                <a href="{{ route('shop.home') }}">
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="ChieuUzu Logo" style="height: 50px; padding-left: 15px">
                </a>
            </div>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav">
                {{-- Danh mục sản phẩm --}}
                <li class="dropdown">
                    <a aria-expanded="false" role="button" href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-th-list"></i> Sản phẩm <span class="caret"></span>
                    </a>
                    <ul role="menu" class="dropdown-menu">
                        @foreach ($categories as $category)
                            @if ($category->children->isNotEmpty())
                                <li class="dropdown-submenu">
                                    <a href="{{ route('shop.category', $category->slug) }}" class="dropdown-toggle" data-toggle="dropdown">
                                        {{ $category->name }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach ($category->children as $child)
                                            <li>
                                                <a href="{{ route('shop.category', $child->slug) }}">{{ $child->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('shop.category', $category->slug) }}">{{ $category->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <!-- Liên hệ -->
                <li>
                    <a href="{{ route('shop.contact') }}">Liên hệ</a>
                </li>
                <!-- Tin tức -->
                <li>
                    <a href="{{ route('shop.news.index') }}">Tin tức</a>
                </li>
                <!-- Tìm kiếm -->
                <li>
                    <form class="navbar-form" action="{{ route('shop.search') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Tìm kiếm..." required>
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-top-links navbar-right">
                <!-- Giỏ hàng -->
                <li>
                    <a href="{{ route('shop.cart') }}">
                        <i class="fa fa-shopping-cart"></i>
                        <span class="badge bg-danger">{{ session('cart_count', 0) }}</span>
                    </a>
                </li>
                <!-- User/Login -->
                <li class="dropdown">
                    @auth
                        <!-- Khi đã đăng nhập -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-user"></i>
                            <span class="badge bg-primary">
                                {{ Auth::user()->orders()->whereIn('status', ['pending', 'confirmed', 'processing'])->where('updated_at', '>', now()->subDays(7))->count() }}
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('shop.profile') }}">
                                    <i class="fa fa-user-circle"></i> Truy cập thông tin tài khoản
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.notifications') }}">
                                    <i class="fa fa-bell"></i> Thông báo
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('shop.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('shop.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    @else
                        <!-- Khi chưa đăng nhập -->
                        <a href="#" data-toggle="modal" data-target="#authModal">
                            <i class="bi bi-person-circle"></i>
                            <small>Đăng nhập</small>
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </nav>
    <!-- Breadcrumb -->
    @if (request()->route()->getName() !== 'shop.home')
        <div class="breadcrumb-wrapper">
            <div class="container">
                <ol class="breadcrumb">
                    @if (isset($breadcrumbs) && !empty($breadcrumbs))
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if ($loop->last)
                                <li class="active">{{ $breadcrumb['title'] }}</li>
                            @else
                                <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div>
        </div>
    @endif
    <!-- Modal Đăng nhập/Đăng ký -->
    <div class="modal fade" id="authModal" tabindex="-1" role="dialog" aria-labelledby="authModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <img src="{{ asset('storage/logo/logo.png') }}" alt="Shop Logo" class="modal-logo" style="max-width: 100px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <h5 class="modal-title" id="authModalLabel"><strong>Chào mừng bạn đến với Chiếu Uzu & Cói</strong></h5>
                    <hr>
                    <div class="mt-4">
                        <a href="{{ route('shop.login') }}" class="btn btn-primary btn-block mb-2">Đăng nhập</a>
                        <a href="{{ route('shop.register') }}" class="btn btn-outline-primary btn-block">Đăng ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>