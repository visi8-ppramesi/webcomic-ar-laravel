<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\PageController;
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
Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api.testing');
    Route::get('/logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::get('/comic/{comic}', [ComicController::class, 'show'])->name('api.comic.show');
    Route::patch('/comic/{comic}', [ComicController::class, 'update'])->name('api.comic.update');
    Route::delete('/comic/{comic}', [ComicController::class, 'destroy'])->name('api.comic.delete');
    Route::post('/comic', [ComicController::class, 'create'])->name('api.comic.create');

    Route::get('/page/{page}', [PageController::class, 'show'])->name('api.page.show');
    Route::patch('/page/{page}', [PageController::class, 'update'])->name('api.page.update');
    Route::delete('/page/{page}', [PageController::class, 'destroy'])->name('api.page.delete');
    Route::post('/page', [PageController::class, 'create'])->name('api.page.create');
    Route::get('/pages/{comic}', [PageController::class, 'index'])->name('api.comic.show.pages');

    Route::patch('/author/{author}', [AuthorController::class, 'update'])->name('api.author.update');
    Route::delete('/author/{author}', [AuthorController::class, 'destroy'])->name('api.author.delete');

    Route::post('/author', [AuthorController::class, 'create'])->name('api.author.create');
});

Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::get('/comics', [ComicController::class, 'index'])->name('api.comics.list');

// Route::get('/pages', [PageController::class, 'index'])->name('api.');

Route::get('/author/{author}', [AuthorController::class, 'show'])->name('api.author.show');
Route::get('/authors', [AuthorController::class, 'index'])->name('api.authors.list');