<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(10);

        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => 'Tin tức', 'url' => null],
        ];
        return view('shop.news.index', compact('news', 'breadcrumbs'));
    }

    public function show($slug)
    {
        $article = News::with('user')
            ->where('slug', $slug)
            ->where('published_at', '<=', now())
            ->firstOrFail();
        
        $breadcrumbs = [
            ['title' => 'Trang chủ', 'url' => route('shop.home')],
            ['title' => 'Tin tức', 'url' => route('shop.news.index')],
            ['title' => $article->title, 'url' => null],
        ];
        return view('shop.news.show', compact('article', 'breadcrumbs'));
    }
}
