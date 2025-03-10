@extends('admin.layouts.master')
@push('styles')
    <link href="{{ asset('admin_assets/css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet">
    <style>
        .pwstrength_viewport_progress {
            padding-top: 15px;
        }

        .progress {
            margin-bottom: 0px;
        }
    </style>
@endpush
@section('title', 'Thêm người dùng')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nhập thông tin người dùng</h5>
                    </div>
                    <div class="ibox-content">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('admin.users.store') }}" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Họ và Tên <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Email <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{ old(key: 'email') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="pwd-container">
                                    <label class="col-sm-2 control-label" for="password">Mật khẩu <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" id="password" class="form-control example"
                                            required>
                                        <div class="pwstrength_viewport_progress" style="padding-top: 20px"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nhập lại mật khẩu <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Số điện thoại</label>
                                <div class="col-sm-10">
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ old('phone') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Địa chỉ</label>
                                <div class="col-sm-10">
                                    <input type="text" name="address" id="address" class="form-control"
                                        value="{{ old('address') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Quyền hạn</label>
                                <div class="col-sm-10">
                                    <div class="i-checks"><input type="radio" name="role" value="admin"> <i></i> Quản trị
                                    </div>
                                    <div class="i-checks"><input type="radio" name="role" value="user" checked> <i></i>
                                        Khách hàng </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ảnh đại diện</label>
                                <div class="col-sm-10">
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                            <span class="fileinput-filename"></span>
                                        </div>
                                        <span class="input-group-addon btn btn-default btn-file">
                                            <span class="fileinput-new">Select file</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" name="avatar" />
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-white">Hủy</a>
                                    <button class="btn btn-primary" type="submit">Thêm mới</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('admin_assets/js/plugins/pwstrength/pwstrength-bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/plugins/pwstrength/zxcvbn.js') }}"></script>
        <script src="{{ asset('admin_assets/js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                //password_meter
                var options1 = {};
                options1.ui = {
                    container: "#pwd-container",
                    showVerdictsInsideProgressBar: true,
                    viewports: {
                        progress: ".pwstrength_viewport_progress"
                    }
                };
                options1.common = {
                    debug: false,
                };
                $('.example').pwstrength(options1);
            })
        </script>
    @endpush
@endsection