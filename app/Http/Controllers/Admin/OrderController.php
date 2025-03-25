<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('customer')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer . '%');
            });
        }
        if ($request->filled('date_added')) {
            $query->whereDate('created_at', $request->date_added);
        }
        if ($request->filled('date_modified')) {
            $query->whereDate('updated_at', $request->date_modified);
        }
        if ($request->filled('amount')) {
            $query->where('total_price', $request->amount);
        }

        $orders = $query->with('user')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:processing,processed',
            'shipping_address' => 'nullable|string',
            'province' => 'nullable|string',
            'district' => 'nullable|string',
            'ward' => 'nullable|string',
            'street' => 'nullable|string',
        ]);

        $order = Order::create($request->all());

        return redirect()->route('admin.orders.index')->with('success', 'Hóa đơn đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('orderDetails.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'processing') {
            return redirect()->route('admin.orders.index')->with('error', 'Không thể chỉnh sửa đơn hàng đã xử lý.');
        }
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'processing') {
            return redirect()->route('admin.orders.index')->with('error', 'Không thể chỉnh sửa đơn hàng đã xử lý.');
        }

        $request->validate([
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'street' => 'required',
            'shipping_address' => 'nullable|string',
            'status' => 'required|in:processing,processed',
        ]);

        $order->update($request->only(['province', 'district', 'ward', 'street', 'shipping_address', 'status']));

        return redirect()->route('admin.orders.index')->with('success', 'Hóa đơn đã được cập nhật.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Hóa đơn đã được xóa thành công.');
    }

    /**
     * Update status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,failed',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        if (in_array($oldStatus, ['delivered', 'cancelled'])) {
            return back()->with('error', 'Không thể thay đổi trạng thái của đơn hàng đã giao hoặc đã hủy.');
        }

        $order->status = $newStatus;
        $order->save();

        return back()->with('success', "Trạng thái đã được cập nhật từ '$oldStatus' sang '$newStatus'.");
    }
}
