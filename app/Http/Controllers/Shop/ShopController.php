<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ShopController extends Controller
{
    public function index()
    {
        $files = File::files(storage_path('app/public/banner'));

        $banners = collect($files)->map(function ($file) {
            return asset('storage/banner/' . $file->getFilename()); // Đường dẫn chính xác
        });

        $categories = Category::whereNull('parent_id')
            ->with([
                'children.products.discounts',
                'products.discounts'
            ])->get();
        return view('shop.home', compact('categories', 'banners'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->with('products')->first();

        if (!$category) {
            abort(404, 'Danh mục không tồn tại.');
        }

        $products = $category->products;

        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => $category->name, 'url' => ''],
        ];

        return view('shop.category', compact('category', 'products', 'breadcrumbs'));
    }
}
