<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::orderBy('id', 'desc')->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:active,inactive',
        ]);

        Discount::create([
            'name' => $request->name,
            'percentage' => $request->percentage,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Khuyến mãi đã được tạo thành công!');
    }



    
    public function edit($slug)
    {
        $discount = Discount::where('slug', $slug)->firstOrFail();
        return view('admin.discounts.edit', compact('discount'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $discount = Discount::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name'        => 'required|string|max:255',
            'percentage'  => 'required|numeric|min:0|max:100',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'status'      => 'required|in:active,inactive',
        ]);

        $discount->update([
            'name'       => $request->name,
            'percentage' => $request->percentage,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'status'     => $request->status,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Cập nhật khuyến mãi thành công!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $discount = Discount::where('slug', $slug)->firstOrFail();
        $discount->delete();

        return redirect()->route('admin.discounts.index')->with('success', 'Xóa khuyến mãi thành công!');
    }
}
