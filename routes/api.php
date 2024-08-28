<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ArticleApiController;
use App\Http\Controllers\Api\CommentApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Article and comment API routes for authenticated users.
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::apiResource('articles', ArticleApiController::class)->except(['index', 'show']);
        Route::apiResource('articles.comments', CommentApiController::class)->only(['index', 'store']);
    });

    // Article public API routes.
    Route::apiResource('articles', ArticleApiController::class)->only(['index', 'show']);

});
