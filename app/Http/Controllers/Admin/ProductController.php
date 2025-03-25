<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::query();

        if ($request->filled('product_name')) {
            $products->where('name', 'like', '%' . $request->product_name . '%');
        }

        if ($request->filled('price')) {
            $products->where('price', '<=', $request->price);
        }

        if ($request->filled('stock')) {
            $products->where('stock', '>=', $request->stock);
        }

        if ($request->filled('category_id')) {
            $products->where('category_id', $request->category_id);
        }

        $products = $products->paginate(10);

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $discounts = Discount::all();
        return view('admin.products.create', compact('categories', 'discounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'discount_id' => 'nullable|exists:discounts,id',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'discount_id' => $request->discount_id
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store("product_images/{$product->slug}", 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['images', 'category', 'warehouses'])->firstOrFail();
        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(6)
            ->get();

        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => 'Chi tiết sản phẩm', 'url' => ''],
        ];
        return view('shop.product-detail', compact('product', 'categories', 'relatedProducts', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $product = Product::with(['category', 'discounts'])->where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $discounts = Discount::all();
        return view('admin.products.edit', compact('product', 'categories', 'discounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $newSlug = Str::slug($request->name);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'slug' => $newSlug
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        Storage::disk('public')->deleteDirectory("product_images/{$product->slug}");

        $product->images()->delete();

        $product->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa thành công.');
    }

    /**
     * Add a discount to product
     */
    public function addDiscountToProduct($productId, $discountId)
    {
        $product = Product::findOrFail($productId);

        $product->update(['discount_id' => $discountId]);

        $product->discounts()->syncWithoutDetaching([$discountId]);

        return redirect()->back()->with('success', 'Thêm khuyến mãi thành công.');
    }

    /**
     * Apply discount to product
     */
    public function applyDiscount(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $discountId = $request->discount_id;

        if (!$discountId) {
            return response()->json(['error' => 'Vui lòng chọn một giảm giá'], 400);
        }

        // Gán discount_id vào bảng products
        $product->update(['discount_id' => $discountId]);

        // Thêm vào bảng discount_product (nếu chưa có)
        $product->discounts()->syncWithoutDetaching([$discountId]);

        return response()->json(['message' => 'Giảm giá đã được áp dụng thành công!']);
    }

    /**
     * Remove discount form product
     */
    public function removeDiscount($productId, $discountId)
    {
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['message' => 'Sản phẩm không tồn tại!'], 404);
        }

        // Kiểm tra xem sản phẩm có discount này không
        if (!$product->discounts->contains($discountId)) {
            return response()->json(['message' => 'Khuyến mãi không tồn tại trên sản phẩm!'], 404);
        }

        // Xóa discount khỏi bảng trung gian discount_product
        $product->discounts()->detach($discountId);

        // Nếu discount_id của product trùng với discount bị xóa, cập nhật về null
        if ($product->discount_id == $discountId) {
            $product->update(['discount_id' => null]);
        }

        return response()->json(['message' => 'Khuyến mãi đã được xóa khỏi sản phẩm thành công!']);
    }
}
