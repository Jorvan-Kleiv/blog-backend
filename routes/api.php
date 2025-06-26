<?php

use App\Http\Controllers\Api\v1\Articles\DeleteArticlesController;
use App\Http\Controllers\Api\v1\Articles\SetStatusController;
use App\Http\Controllers\Api\v1\Articles\UserConnectedArticlesController;
use App\Http\Controllers\Api\v1\Comments\CreateCommentController;
use App\Http\Controllers\Api\v1\Comments\ReplyCommentController;
use App\Http\Controllers\LikeArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\Auth\AuthenticationController;
use App\Http\Controllers\Api\v1\Articles\GetArticlesController;
use App\Http\Controllers\Api\v1\Articles\LoadArticleByIdController;
use App\Http\Controllers\Api\v1\Articles\LoadArticlesController;
use App\Http\Controllers\Api\v1\Articles\StoreArticleController;
use App\Http\Controllers\Api\v1\Articles\UpdateArticleController;
use App\Http\Controllers\UserWithArticleCountController;
use App\Http\Resources\UserResource;

Route::get('/user', function (Request $request) {
    return UserResource::make($request->user());
})->middleware('auth:sanctum');
Route::post('/register', RegisterController::class)->withoutMiddleware('auth:sanctum');
Route::post('/login', AuthenticationController::class);
Route::middleware(['auth:sanctum'])->prefix('/v1')->group(function ()
{
    Route::group(['prefix' => 'articles'], function () {
        Route::get('/', GetArticlesController::class)->withoutMiddleware('auth:sanctum');
        Route::get('/auth/articles', UserConnectedArticlesController::class);
        Route::post('/article', StoreArticleController::class);
        Route::get('/trending', UserWithArticleCountController::class)->withoutMiddleware('auth:sanctum');
        Route::get('/article/{article}', LoadArticleByIdController::class);
        Route::match(['put', 'post'],'/article/{article}', UpdateArticleController::class);
        Route::patch('/article/{article}', SetStatusController::class);
        Route::delete('/article/{article}', DeleteArticlesController::class);
        Route::post('/article/{article}/likes', LikeArticleController::class);
        //route for Articles comment
        Route::post('/article/comment/{article}', CreateCommentController::class);
        Route::post('/article/replied/{comment}', ReplyCommentController::class);
    });
});


