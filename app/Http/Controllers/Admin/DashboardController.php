<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){

        // Lấy khoảng thời gian từ request
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // Tổng doanh thu
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'delivered')
            ->sum('total_price');

        // Tổng số đơn hàng
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        // Tổng số khách hàng mới
        $newCustomers = User::whereBetween('created_at', [$startDate, $endDate])
            ->count();
        
        // Số sản phẩm sắp hết hàng
        $lowStockProducts = Product::whereHas('warehouses', function ($query) {
            $query->where('warehouse_products.quantity', '<', 10);
        })->with('warehouses')->get()->filter(function ($product) {
            return $product->total_stock < 10;
        })->count();

        // Doanh thu theo ngày (cho biểu đồ)
        $dailyRevenue = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('status', 'delivered')
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        
        $chartData = [
            'labels' => $dailyRevenue->pluck('date'),
            'data' => $dailyRevenue->pluck('total'),
        ];

        // Trạng thái đơn hàng (cho biểu đồ tròn)
        $orderStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statusChartData = [
            'labels' => array_keys($orderStatus),
            'data' => array_values($orderStatus),
        ];

        // Đơn hàng gần đây
        $recentOrders = Order::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Sản phẩm sắp hết hàng
        $lowStockProductsList = Product::whereHas('warehouses', function ($query) {
            $query->where('warehouse_products.quantity', '<', 10);
        })->with('warehouses')->get()->filter(function ($product) {
            return $product->total_stock < 10;
        })->take(5);

        return view('admin.dashboard.index', compact(
            'totalRevenue',
            'totalOrders',
            'newCustomers',
            'lowStockProducts',
            'chartData',
            'statusChartData',
            'recentOrders',
            'lowStockProductsList',
            'startDate',
            'endDate'
        ));
    }
}
