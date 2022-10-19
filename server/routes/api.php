<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/category/export', [CategoryController::class,'export']);
Route::post('/category/import', [CategoryController::class, 'import']);

Route::resource("category", CategoryController::class);

Route::get('post', [PostController::class, 'index']);
Route::post('post', [PostController::class, 'store']);
Route::get('post/{id}', [PostController::class, 'show']);
Route::post('post/{id}', [PostController::class, 'update']);
Route::delete('post/{id}', [PostController::class, 'destroy']);

Route::post('comment', [CommentController::class, 'store']);
Route::get('comment/{id}', [CommentController::class, 'index']);
Route::delete('comment/{id}', [CommentController::class, 'destroy']);