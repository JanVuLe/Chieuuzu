<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        Storage::delete("public/" . $image->image_url);

        $image->delete();

        return back()->with('success', 'Ảnh đã được xóa.');
    }
    public function store(Request $request, $productSlug)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::where('slug', $productSlug)->firstOrFail();

        $folderPath = "public/product_images/{$product->slug}";
        $fileName = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs($folderPath, $fileName);

        $productImage = new ProductImage();
        $productImage->product_id = $product->id;
        $productImage->image_url = str_replace('public/', '', $path);
        $productImage->save();

        return back()->with('success', 'Ảnh đã được tải lên thành công.');
    }
}
