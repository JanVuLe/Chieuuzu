@extends('admin.layouts.master')
@section('title', 'Chi tiết kho hàng')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kho hàng: {{ $warehouse->name }} ({{ $warehouse->location }})</h5>
                    </div>
                    <div class="ibox-content">
                        <h4>Danh sách sản phẩm trong kho</h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouse->warehouseProducts as $wp)
                                    <tr>
                                        <td>{{ $wp->product->id }}</td>
                                        <td>{{ $wp->product->name }}</td>
                                        <td>{{ $wp->quantity }}</td>
                                        <td>
                                            <form action="{{ route('admin.warehouses.removeProduct', [$warehouse->id, $wp->product->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi kho?')">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h4>Thêm sản phẩm vào kho</h4>
                        <form action="{{ route('admin.warehouses.addProduct', $warehouse->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="product_id">Chọn sản phẩm</label>
                                <select name="product_id" class="form-control">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Số lượng</label>
                                <input type="number" name="quantity" class="form-control" min="1" required>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
