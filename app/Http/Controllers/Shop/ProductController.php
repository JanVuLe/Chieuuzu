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
        return view('shop.product-detail', compact('product', 'categories'));
    }
}
