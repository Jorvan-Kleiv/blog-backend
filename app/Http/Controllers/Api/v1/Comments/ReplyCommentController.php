<?php

namespace App\Http\Controllers\Api\v1\Comments;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReplyCommentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:2'],
        ]);
        $reply = $comment->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);
        return CommentResource::make($reply)->response()->setStatusCode(201);
    }
}
