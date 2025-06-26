<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Status;
use App\Models\Tag;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;

class UpdateArticleController extends Controller
{
    /**
     * Handle the incoming request.
     * @return null
     */
    public function __invoke(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => ['string','max:255'],
            'content' => ['nullable','string'],
            'tags' => ['nullable', 'string'],
            'image' => ['nullable','sometimes','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
        ]);
        if ($request->hasFile('image')) {
            if ($article->image && Storage::disk('public')->exists($article->image->path)) {
                Storage::disk('public')->delete($article->image->path);
            }
            $imageName = $request->file('image')->getClientOriginalName();
            $finalImageName = str_replace(' ', '-', $imageName);
            $path = $request->image->storeAs('images', $finalImageName, 'public');
            if ($article->image) {
                $article->image()->update([
                    'name' => $finalImageName,
                    'path' => $path,
                ]);
            } else {
                $article->image()->create([
                    'name' => $finalImageName,
                    'path' => $path,
                ]);
            }
        }
        if (!empty($validated['tags'])) {
            $tagNames = array_map('trim', explode(',', strtolower($validated['tags'])));
            $tagIds = collect($tagNames)->map(function ($name) {
                return Tag::firstOrCreate(['name' => ucfirst($name)])->id;
            });
            $article->tags()->sync($tagIds);
        }
        unset($validated['image']);
        $article->update($validated);
        return ArticleResource::make($article);
    }
}
