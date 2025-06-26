<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;

class UserWithArticleCountController extends Controller
{
    function __invoke(Request $request)
    {
        $topUsers = User::withCount('articles') // "articles_count" sera généré automatiquement
            ->orderByDesc('articles_count')
            ->take(5)
            ->get();

        return UserResource::collection($topUsers);
    }

}
