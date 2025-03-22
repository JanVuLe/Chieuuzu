<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['images', 'category'])->firstOrFail();

        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();

        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->with('images')->take(6)->get();

        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => 'Chi tiết sản phẩm', 'url' => ''],
        ];
        return view('shop.product-detail', compact('product', 'categories', 'relatedProducts', 'breadcrumbs'));
    }
}
