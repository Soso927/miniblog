<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin', function () {
    return 'Zone admin : accès réservé';
})->middleware(['auth', 'role:admin'])->name('admin.home');

Route::get('/', [PostController::class, 'publicIndex'])->name('home');

require __DIR__.'/auth.php';


Route::prefix('dashboard')
    ->name('posts.')
    ->middleware(['auth','verified'])
    ->group(function () {
        Route::get('/posts',        [PostController::class, 'index'])->name('index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('create')->middleware('permission:posts.create');
        Route::post('/posts',       [PostController::class, 'store'])->name('store')->middleware('permission:posts.create');

        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/posts/{post}',      [PostController::class, 'update'])->name('update');

        Route::delete('/posts/{post}',   [PostController::class, 'destroy'])->name('destroy');

        // publication / dépublication (réservé aux éditeurs/admin via permission)
        Route::post('/posts/{post}/publish',   [PostController::class, 'publish'])->name('publish')->middleware('permission:posts.publish');
        Route::post('/posts/{post}/unpublish', [PostController::class, 'unpublish'])->name('unpublish')->middleware('permission:posts.publish');
    });
