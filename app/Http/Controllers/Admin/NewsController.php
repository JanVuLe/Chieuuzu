<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('user')->latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }
        $data['slug'] = $slug;
        $data['user_id'] = auth()->id();
        $article = News::create($data);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("news/{$article->slug}", 'public');
            $article->update(['image' => $path]);
        }

        return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được thêm!');
    }

    public function show(string $slug)
    {
        $article = News::with('user')->where('slug', $slug)->firstOrFail();
        return view('admin.news.show', compact('article'));
    }

    public function edit(string $slug)
    {
        $article = News::where('slug', $slug)->firstOrFail();
        return view('admin.news.edit', compact('article'));
    }

    public function update(Request $request, string $slug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $article = News::where('slug', $slug)->firstOrFail();
        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store("news/{$article->slug}", 'public');
        }

        $article->update($data);
        return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được cập nhật!');
    }

    public function destroy(string $slug)
    {
        $article = News::where('slug', $slug)->firstOrFail();
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return redirect()->route('admin.news.index')->with('success', 'Bài viết đã được xóa!');
    }
}