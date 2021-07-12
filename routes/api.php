<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ComicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/comic/{comic}', [ComicController::class, 'show']);
Route::patch('/comic/{comic}', [ComicController::class, 'update']);
Route::delete('/comic/{comic}', [ComicController::class, 'destroy']);
Route::post('/comic', [ComicController::class, 'create']);
Route::get('/comics', [ComicController::class, 'index']);

Route::get('/page/{page}', [PageController::class, 'show']);
Route::patch('/page/{page}', [PageController::class, 'update']);
Route::delete('/page/{page}', [PageController::class, 'destroy']);
Route::post('/page', [PageController::class, 'create']);
Route::get('/pages', [PageController::class, 'index']);

Route::get('/author/{author}', [AuthorController::class, 'show']);
Route::patch('/author/{author}', [AuthorController::class, 'update']);
Route::delete('/author/{author}', [AuthorController::class, 'destroy']);
Route::post('/author', [AuthorController::class, 'create']);
Route::get('/authors', [AuthorController::class, 'index']);