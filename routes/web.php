<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog/{blog}', [HomeController::class, 'show'])->name('blog.show');

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        // Redirect based on user role
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.blogs.index');
        }
        return redirect()->route('blogs.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User blog routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::resource('blogs', BlogController::class);
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/blogs/{blog}', [AdminBlogController::class, 'show'])->name('admin.blogs.show');
    Route::patch('/blogs/{blog}/status', [AdminBlogController::class, 'updateStatus'])->name('admin.blogs.updateStatus');
});

require __DIR__.'/auth.php';
