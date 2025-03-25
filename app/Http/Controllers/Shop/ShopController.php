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
        $files = File::files(storage_path('app/public/banner')); // Dùng File::files() thay vì Storage::files()

        $banners = collect($files)->map(function ($file) {
            return asset('storage/banner/' . $file->getFilename()); // Đường dẫn chính xác
        });

        $categories = Category::whereNull('parent_id')->with(['children', 'products'])->get();
        return view('shop.home', compact('categories', 'banners'));
    }
}
