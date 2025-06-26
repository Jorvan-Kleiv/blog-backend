<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserConnectedArticlesController extends Controller
{
    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $articles = Article::query()
        ->whereBelongsTo($request->user())
            ->with('user')
            ->with('comments')
            ->with('tags')
            ->with('image')
            ->orderByDesc('created_at')
            ->paginate(15)
        ;

        return ArticleResource::collection($articles);
    }
}
