<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('images')
            ->latest()
            ->paginate(12);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:8192',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $article = Article::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'content' => $validated['content'],
            'created_by' => $request->user()->id,
        ]);

        $this->syncImages($article, $request);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Статья успешно создана.');
    }

    public function edit(Article $article)
    {
        $article->load('images');
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|max:8192',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer',
        ]);

        $article->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'] ?? null,
            'content' => $validated['content'],
        ]);

        $removeIds = collect($request->input('remove_images', []))
            ->map(fn ($id) => (int) $id)
            ->all();

        if (!empty($removeIds)) {
            $article->images()
                ->whereIn('id', $removeIds)
                ->get()
                ->each(function ($image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                });
        }

        $this->syncImages($article, $request);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Статья успешно обновлена.');
    }

    public function destroy(Article $article)
    {
        $article->images->each(function ($image) {
            Storage::disk('public')->delete($image->image_path);
        });

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Статья удалена.');
    }

    private function syncImages(Article $article, Request $request): void
    {
        $uploadedImages = $request->file('images', []);
        $captions = $request->input('captions', []);

        foreach ($uploadedImages as $index => $imageFile) {
            $path = $imageFile->store('articles', 'public');

            $article->images()->create([
                'image_path' => $path,
                'caption' => $captions[$index] ?? null,
                'sort_order' => $index,
            ]);
        }
    }
}
