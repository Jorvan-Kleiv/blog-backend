<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DeleteArticlesController extends Controller
{
    public function __invoke(Request $request, Article $article)
    {
        $articleToDelete = Article::query()->findOrFail($article->id);
        if ($articleToDelete || $articleToDelete->comments()->count() == 0) {
            $articleToDelete->delete();
            return response()->json([
                'message' => 'Article has been deleted successfully'
            ]);
        }
        return response()->json([
            'message' => 'Article cannot be deleted'
        ], 403);
    }
}
