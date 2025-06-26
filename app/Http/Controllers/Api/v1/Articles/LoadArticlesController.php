<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Article;
use Illuminate\Http\Request;

class LoadArticlesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $articles = Article::query()
            ->with('user')
            ->with('comments')
            ->with('tags')
            ->with('image')
            ->orderByDesc('created_at')
            ->paginate(15)
        ;
        return new UserResource($articles);
    }
}
