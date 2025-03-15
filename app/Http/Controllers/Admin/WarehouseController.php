<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('admin.warehouses.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.warehouses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Warehouse::create([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.warehouses.index')->with('success', 'Kho hàng đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $warehouse = Warehouse::with('warehouseProducts.product')->findOrFail($id);
        $products = Product::whereNotIn('id', $warehouse->warehouseProducts->pluck('product_id'))->get();

        return view('admin.warehouses.show', compact('warehouse', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        return view('admin.warehouses.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $warehouse = Warehouse::findOrFail($id);
        $warehouse->update([
            'name' => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->route('admin.warehouses.index')->with('success', 'Kho hàng đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warehouse = Warehouse::findOrFail($id);

        if ($warehouse->warehouseProducts()->count() > 0) {
            return redirect()->route('admin.warehouses.index')->with('error', 'Không thể xóa kho hàng vì vẫn còn sản phẩm trong kho.');
        }

        $warehouse->delete();

        return redirect()->route('admin.warehouses.index')->with('success', 'Kho hàng đã được xóa thành công!');
    }

    /**
     * Add product to warehouse
     */
    public function addProduct(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        WarehouseProduct::updateOrCreate(
            [
                'warehouse_id' => $id,
                'product_id' => $request->product_id,
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return redirect()->route('admin.warehouses.show', $id)->with('success', 'Sản phẩm đã được thêm vào kho!');
    }

    /**
     * Remove product form warehouse
     */

    public function removeProduct($warehouseId, $productId)
    {
        WarehouseProduct::where('warehouse_id', $warehouseId)
            ->where('product_id', $productId)
            ->delete();

        return redirect()->route('admin.warehouses.show', $warehouseId)->with('success', 'Sản phẩm đã được xóa khỏi kho!');
    }
}
