<?php

namespace App\Http\Controllers\Api\v1\Comments;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use Illuminate\Http\Request;

class CreateCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Article $article)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:2'],
        ]);
        $commentToCreate = $article->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);
        return CommentResource::make($commentToCreate);
    }
}
