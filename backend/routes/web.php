<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminArticleController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AdminArticleController::class, 'index'])->name('dashboard');
    
    Route::get('/admin/articles/create', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/admin/articles', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/admin/articles/{id}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/admin/articles/{id}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/admin/articles/{id}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
