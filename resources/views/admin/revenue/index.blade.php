@extends('admin.layouts.master')

@section('title', 'Thống kê doanh thu')

@section('content')
    <div class="container-fluid">
        <!-- Form lọc khoảng thời gian -->
        <div class="row mb-4 p-xs">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Lọc doanh thu</h5>
                        <form method="GET" action="{{ route('admin.revenue.index') }}" class="form-inline justify-content-between">
                            <div class="input-group mb-2 mb-md-0 me-2">
                                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="form-control">
                            </div>
                            <div class="input-group mb-2 mb-md-0 me-2">
                                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tổng doanh thu -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-gradient-primary text-white">
                    <div class="card-body d-flex align-items-center">
                        <h5 class="card-title mb-0 me-3 p-xs"><i class="bi bi-cash-stack me-2"></i>Tổng doanh thu</h5>
                        <h3 class="mb-0 p-xs">{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ doanh thu -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-bar-chart-line"></i> Biểu đồ doanh thu theo ngày</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết doanh thu -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-table"></i> Chi tiết doanh thu</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Doanh thu (VNĐ)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dailyRevenue as $revenue)
                                        <tr>
                                            <td>{{ $revenue->date }}</td>
                                            <td>{{ number_format($revenue->total, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">Không có dữ liệu</td>
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
        .card {
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .card-title{
            padding-left: 10px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .input-group-text {
            border-radius: 5px 0 0 5px;
        }
        .btn-primary.btn-sm {
            border-radius: 5px;
            padding: 6px 12px; /* Thu nhỏ nút */
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
            width: auto; /* Đảm bảo ô nhập ngày không bị quá rộng */
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/plugins/chartJs/Chart.min.js') }}"></script>
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
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
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });
    </script>
@endpush