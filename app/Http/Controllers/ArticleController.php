<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        $articles = Article::query()
            ->with('images')
            ->withCount('favoritedByUsers')
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($inner) use ($query) {
                    $inner->where('title', 'like', '%' . $query . '%')
                        ->orWhere('subtitle', 'like', '%' . $query . '%');
                });
            })
            ->latest()
            ->paginate(4);

        if ($query !== '') {
            $articles->appends(['q' => $query]);
        }

        $favoriteIds = Auth::user()
            ->favoriteArticles()
            ->pluck('articles.id')
            ->all();

        if ($request->ajax()) {
            return response()->view('user.articles.partials.index-async', compact('articles', 'favoriteIds'));
        }

        return view('user.articles.index', compact('articles', 'favoriteIds', 'query'));
    }

    public function favorites()
    {
        $user = Auth::user();

        $articles = $user->favoriteArticles()
            ->with('images')
            ->withCount('favoritedByUsers')
            ->latest()
            ->paginate(9);

        $favoriteIds = $user->favoriteArticles()->pluck('articles.id')->all();

        return view('user.articles.favorites', compact('articles', 'favoriteIds'));
    }

    public function show(Article $article)
    {
        $article->load(['images', 'author']);

        $isFavorite = Auth::user()
            ->favoriteArticles()
            ->where('articles.id', $article->id)
            ->exists();

        return view('user.articles.show', compact('article', 'isFavorite'));
    }

    public function toggleFavorite(Article $article)
    {
        $user = Auth::user();

        if ($user->favoriteArticles()->where('articles.id', $article->id)->exists()) {
            $user->favoriteArticles()->detach($article->id);
            return back()->with('success', 'Статья удалена из избранного.');
        }

        $user->favoriteArticles()->attach($article->id);
        return back()->with('success', 'Статья добавлена в избранное.');
    }
}
