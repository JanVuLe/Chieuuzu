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
            <a href="{{ route('shop.home') }}" class="navbar-brand">ChieuUzu</a>
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
                            <li><a href="{{ route('shop.category', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
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
                <!-- Đăng nhập / Đăng xuất -->
                @auth
                    <li>
                        <a href="{{ route('shop.profile') }}">
                            <i class="fa fa-user"></i> {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> Đăng xuất
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('shop.login') }}">
                            <i class="fa fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    
</header>