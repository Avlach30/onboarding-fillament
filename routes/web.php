<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Define the resource route for the PostController, which will create the following routes:
 * GET /posts
 * GET /posts/create
 * POST /posts
 * GET /posts/{post}
 * GET /posts/{post}/edit
 * PUT/PATCH /posts/{post}
 * DELETE /posts/{post}
 */
Route::resource('posts', PostController::class);
