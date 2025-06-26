<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\UserResource;
use App\Models\Article;
use App\Status;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GetArticlesController extends Controller
{
    /**
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        $articles = Article::with(['user', 'tags', 'image', 'comments'])
            ->latest('created_at')
            ->paginate(10);

        return ArticleResource::collection($articles);
    }
}
