<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;

Route::redirect('/', '/books');
Route::resource('books', BookController::class);
