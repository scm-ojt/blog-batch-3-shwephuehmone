<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Api\CategoryController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/category/export', [CategoryController::class,'export']);
Route::post('/category/import', [CategoryController::class, 'import']);

Route::resource('category', CategoryController::class);

Route::post('/post/export', [PostController::class,'export']);
Route::post('/post/import', [PostController::class, 'import']);

Route::resource("post", PostController::class);

Route::post('comment', [CommentController::class, 'store']);
Route::get('comment/{id}', [CommentController::class, 'index']);
Route::delete('comment/{id}', [CommentController::class, 'destroy']);

Route::get('sendmail', [MailController::class, 'index']);