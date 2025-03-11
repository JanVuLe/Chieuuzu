<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                    <img alt="Avatar" class="img-circle" src="{{ Auth::user()->avatar ? asset('storage/avatars/' . Auth::user()->avatar) : asset('storage/avartars/default-avatar.jpg') }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                            </span>
                            <span class="text-muted text-xs block">Xem thêm<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('admin.profile') }}">Thông tin</i></a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.logout') }}">Đăng Xuất</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-th-large"></i><span class="nav-label">Bảng điều khiển</span></a></li>
            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}"><i class="fa fa-users "></i><span class="nav-label">Người dùng</span></a></li>
            <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><a href="{{ route('admin.categories.index') }}"><i class="fa fa-bookmark"></i><span class="nav-label">Danh mục sản phẩm</span></a></li>
            <li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <a href="{{ route('admin.products.index') }}"><i class="fa fa-shopping-cart"></i><span class="nav-label">Sản phẩm</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}"><a href="{{ route('admin.products.index') }}">Danh sách sản phẩm</a></li>
                    <li class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}"><a href="{{ route('admin.products.create') }}">Thêm sản phẩm</a></li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}">
                <a href="{{ route('admin.discounts.index') }}"><i class="fa fa-money"></i><span class="nav-label">Khuyến mãi</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}"><a href="{{ route('admin.discounts.index') }}">Khuyến mãi</a></li>
                    <li class=""><a href="#">Mã khuyến mãi</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>