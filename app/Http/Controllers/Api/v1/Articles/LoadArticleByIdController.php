<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\UserResource;

class LoadArticleByIdController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Article $article)
    {
        $articleRequired = Article::with(['user', 'image', 'comments', 'tags'])->findOrFail($article->id);
        return ArticleResource::make($articleRequired);
    }
}
