<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{ asset('admin_assets/img/profile_small.jpg') }}" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">a N</strong>
                            </span>
                            <span class="text-muted text-xs block">Xem thêm<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('admin.profile') }}">Thông tin</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('admin.logout') }}">Đăng Xuất</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-th-large"></i><span>Bảng điều khiển</span></a></li>
            <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}"><i class="fa fa-users  "></i><span>Người dùng</span></a></li>
        </ul>
    </div>
</nav>