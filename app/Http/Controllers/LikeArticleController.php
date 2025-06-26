<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class LikeArticleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Article $article)
    {
        if ($article->likedBy()->where('user_id', Auth::user()->id)->exists()) {
            $article->likedBy()->detach(Auth::user()->id);
            return response()->json([
                'message' => 'unliked',
            ]);
        }
        $article->likedBy()->attach(Auth::user()->id);
        return response()->json([
            'message' => 'Liked',
        ]);
    }
}
