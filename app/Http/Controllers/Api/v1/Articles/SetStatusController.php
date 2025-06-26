<?php

namespace App\Http\Controllers\Api\v1\Articles;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SetStatusController extends Controller
{
    /**
     * Handle the incoming request.
     * @param Request $request
     * @param Article $article
     */
    public function __invoke(Request $request, Article $article)
    {
        $request->validate([
            'status' => ['required', Rule::in(array_column(Status::cases(), 'value'))]
        ]);

        $article->update([
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'message' => 'Article status updated successfully.',
        ]);


    }
}
