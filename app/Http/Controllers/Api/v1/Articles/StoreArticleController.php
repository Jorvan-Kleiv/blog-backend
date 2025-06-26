<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreArticleController extends Controller
{
    /**
     * @param Request $request
     * @return ArticleResource
     */
    public function __invoke(Request $request): ArticleResource
    {
        $incomingFields = $request->validate([
            'title' => ['required', 'string', 'min:3'],
            'content' => ['required', 'string', 'min:3'],
            'image' => ['nullable', 'sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5048'],
            'tags' => ['nullable'],
        ]);

        $article = Auth::user()->articles()->create($incomingFields);
        if ($incomingFields['tags'] ?? false)
        {
            foreach (explode(',', $incomingFields['tags']) as $tag)
            {
                $article->tag($tag);
            }
        }
        if (request()->hasFile('image')) {
            $image = $request->file('image')->getClientOriginalName();
            $finalImageName = str_replace(' ', '_', $image);
            $imageToUpload = new Image([
                'name' => $finalImageName,
                'path' => $request->file('image')->storeAs('images', $finalImageName, 'public'),
                'imageable_id' => $article->id,
                'imageable_type' => Article::class,
            ]);
            $imageToUpload->save();
        }
        return new ArticleResource($article);

    }
}
