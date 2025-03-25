@extends('admin.layouts.master')
@section('title', 'Quản lý hóa đơn')
@push('styles')
<link href="{{ asset('assets/css/plugins/footable/footable.core.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
    .label-delivered {
        background-color: #28a745;
    }
    .label-failed {
        background-color: #c9302c;
    }
</style>
@endpush
@section('content')
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content m-b-sm border-bottom">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="order_id">Order ID</label>
                        <input type="text" id="order_id" name="order_id" value="{{ request('order_id') }}" placeholder="Order ID" class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="status">Order Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">Tất cả trạng thái</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đã giao hàng</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Hoàn tất</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Thất bại</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="customer">Customer</label>
                        <input type="text" id="customer" name="customer" value="{{ request('customer') }}" placeholder="Tên khách hàng" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="date_added">Date Added</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input id="date_added" type="text" name="date_added" class="form-control" value="{{ request('date_added') }}" placeholder="Chọn ngày">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="date_modified">Date Modified</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input id="date_modified" type="text" name="date_modified" class="form-control" value="{{ request('date_modified') }}" placeholder="Chọn ngày">
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="amount">Amount</label>
                        <input type="text" id="amount" name="amount" value="{{ request('amount') }}" placeholder="Số tiền (VD: 1000000)" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Tìm kiếm</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-default"><i class="fa fa-times"></i> Xóa bộ lọc</a>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="15">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th data-hide="phone">Tên khách hàng</th>
                                <th data-hide="phone">Tổng tiền</th>
                                <th data-hide="phone">Ngày tạo</th>
                                <th data-hide="phone, tablet">Ngày cập nhật</th>
                                <th data-hide="phone">Trạng thái</th>
                                    <th class="text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>{{ number_format($order->total_price, 2) }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td>{{ $order->updated_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="label 
                                        @switch($order->status)
                                            @case('pending') label-default @break
                                            @case('confirmed') label-info @break
                                            @case('processing') label-warning @break
                                            @case('shipped') label-success @break
                                            @case('delivered') label-delivered @break
                                            @case('cancelled') label-danger @break
                                            @case('failed') label-failed @break
                                            @default label-default
                                        @endswitch">
                                        @switch($order->status)
                                            @case('pending') Chờ xác nhận @break
                                            @case('confirmed') Đã xác nhận @break
                                            @case('processing') Đang xử lý @break
                                            @case('shipped') Đã giao hàng @break
                                            @case('delivered') Hoàn tất @break
                                            @case('cancelled') Đã hủy @break
                                            @case('failed') Thất bại @break
                                            @default {{ $order->status }}
                                        @endswitch
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-white btn btn-xs">View</a>
                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-white btn btn-xs" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    {{ $orders->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="{{ asset('assets/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/js/plugins/footable/footable.all.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('.input-group.date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });

        $('.footable').footable();

        $('#date_added').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

        $('#date_modified').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

    });
</script>
@endpush
@endsection