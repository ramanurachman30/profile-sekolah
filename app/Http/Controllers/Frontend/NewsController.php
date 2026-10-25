<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $categories = NewsCategory::withCount('articles')->get();

        $query = NewsArticle::with(['category', 'cover'])->published();

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(9)->withQueryString();
        $recentNews = NewsArticle::with(['category', 'cover'])->published()->take(4)->get();

        return view('frontend.news.index', compact('categories', 'articles', 'recentNews'));
    }

    public function show(string $slug): View
    {
        $article = NewsArticle::with(['category', 'cover', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        $article->incrementViews();

        $recentNews = NewsArticle::with(['category', 'cover'])
            ->published()
            ->where('id', '!=', $article->id)
            ->take(4)
            ->get();

        $categories = NewsCategory::withCount('articles')->get();

        return view('frontend.news.show', compact('article', 'recentNews', 'categories'));
    }
}
