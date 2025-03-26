<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Lấy khoảng thời gian từ request
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Thống kê doanh thu theo ngày trong khoảng thời gian
        $dailyRevenue = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_price) as total')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'delivered') // Chỉ tính đơn hàng đã giao
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tổng doanh thu trong khoảng thời gian
        $totalRevenue = $dailyRevenue->sum('total');

        // Chuẩn bị dữ liệu cho biểu đồ
        $chartData = [
            'labels' => $dailyRevenue->pluck('date'),
            'data' => $dailyRevenue->pluck('total'),
        ];

        return view('admin.revenue.index', compact('dailyRevenue', 'totalRevenue', 'chartData', 'startDate', 'endDate'));
    }
}
