<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');
Route::post('/blogs/filter', [BlogController::class, 'filter'])->name('blogs.filter');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login');
});

Route::middleware('auth')->group(function () {
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/blogs', [AdminController::class, 'blogs'])->name('admin.blogs');
    Route::get('/admin/blogs/create', [AdminController::class, 'create'])->name('admin.blogs.create');
    Route::post('/admin/blogs', [AdminController::class, 'store'])->name('admin.blogs.store');
    Route::get('/admin/blogs/{blog}/edit', [AdminController::class, 'edit'])->name('admin.blogs.edit');
    Route::put('/admin/blogs/{blog}', [AdminController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/admin/blogs/{blog}', [AdminController::class, 'destroy'])->name('admin.blogs.destroy');
});
