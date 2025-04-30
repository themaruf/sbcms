<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\MetricsController;
use App\Http\Middleware\AdminMiddleware;

// Public endpoints
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:60,1');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:60,1');
Route::get('/articles/public', [ArticleController::class, 'index']);

// Authenticated endpoints
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    Route::get('/articles', [ArticleController::class, 'userArticles']);
    Route::get('/articles/{article}', [ArticleController::class, 'show']);
    Route::get('/subscription', [SubscriptionController::class, 'show']);
    Route::post('/subscription/activate', [SubscriptionController::class, 'activate']);

    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/access-log', [AccessLogController::class, 'index']);
        Route::get('/metrics', [MetricsController::class, 'index']);
    });
});
