<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/articles', [ArticleController::class, 'index']);
Route::get('/api/articles/filters', [ArticleController::class, 'getFilterValues']);
