@extends('admin.layouts.master')

@section('title', 'Bảng điều khiển')

@section('content')
    <div class="container-fluid">
        <!-- Form lọc khoảng thời gian -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Lọc dữ liệu</h5>
                        <form method="GET" action="{{ route('admin.dashboard.index') }}" class="form-inline justify-content-between">
                            <div class="input-group mb-2 mb-md-0 me-2">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar"></i></span>
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="form-control">
                            </div>
                            <div class="input-group mb-2 mb-md-0 me-2">
                                <span class="input-group-text bg-light"><i class="bi bi-calendar"></i></span>
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng quan số liệu -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-gradient-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-cash-stack me-2"></i>Tổng doanh thu</h6>
                        <h4>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-gradient-success text-white">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-cart-check me-2"></i>Tổng đơn hàng</h6>
                        <h4>{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-gradient-info text-white">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-person-plus me-2"></i>Khách hàng mới</h6>
                        <h4>{{ $newCustomers }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 bg-gradient-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title"><i class="bi bi-exclamation-triangle me-2"></i>Sản phẩm sắp hết</h6>
                        <h4>{{ $lowStockProducts }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-bar-chart-line"></i> Doanh thu theo ngày</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-pie-chart"></i> Trạng thái đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách nhanh -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-list-ul"></i> Đơn hàng gần đây</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Khách hàng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ $order->status }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Không có đơn hàng</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-exclamation-circle"></i> Sản phẩm sắp hết hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Tổng tồn kho</th>
                                        <th>Chi tiết kho</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($lowStockProductsList as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->total_stock }}</td>
                                            <td>
                                                @foreach ($product->warehouses as $warehouse)
                                                    {{ $warehouse->name }}: {{ $warehouse->pivot->quantity }}<br>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Không có sản phẩm</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(90deg, #007bff, #00c4cc);
        }
        .bg-gradient-success {
            background: linear-gradient(90deg, #28a745, #34c759);
        }
        .bg-gradient-info {
            background: linear-gradient(90deg, #17a2b8, #1ac6d9);
        }
        .bg-gradient-warning {
            background: linear-gradient(90deg, #ffc107, #ffd43b);
        }
        .card {
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .input-group-text {
            border-radius: 5px 0 0 5px;
        }
        .btn-primary.btn-sm {
            border-radius: 5px;
            padding: 6px 12px;
            font-size: 14px;
        }
        .table thead th {
            background-color: #343a40;
            color: white;
            border: none;
        }
        .table tbody tr:hover {
            background-color: #f1f3f5;
        }
        .form-inline .input-group {
            width: auto;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/plugins/chartJs/Chart.min.js') }}"></script>
    <script>
        // Biểu đồ doanh thu
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: @json($chartData['data']),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN');
                            }
                        }
                    }
                }
            }
        });

        // Biểu đồ trạng thái đơn hàng
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: @json($statusChartData['labels']),
                datasets: [{
                    label: 'Trạng thái đơn hàng',
                    data: @json($statusChartData['data']),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(201, 203, 207, 0.7)'
                    ],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>
@endpush