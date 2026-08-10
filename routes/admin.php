<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
| Prefix: /admin
| Name prefix: admin.
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'));

// CMS Resource Routes
Route::resource('news', NewsController::class);
Route::resource('announcements', AnnouncementController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('documents', DocumentController::class);
