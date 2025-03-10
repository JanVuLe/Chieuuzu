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
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-th-large"></i><span>Bảng điều khiển</span></a></li>
            <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}"><i class="fa fa-users "></i><span>Người dùng</span></a></li>
            <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><a href="{{ route('admin.categories.index') }}"><i class="fa fa-bookmark"></i><span>Danh mục sản phẩm</span></a></li>
            <li class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><a href="{{ route('admin.products.index') }}"><i class="fa fa-shopping-cart"></i><span>Sản phẩm</span></a></li>

        </ul>
    </div>
</nav>