<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ExtracurricularController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\VideoController;
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

// Settings & Profiles
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
Route::resource('profiles', SchoolProfileController::class)->only(['index', 'update']);

// CMS Resource Routes
Route::resource('sliders', SliderController::class);
Route::resource('news-categories', NewsCategoryController::class);
Route::resource('news', NewsController::class);
Route::resource('announcements', AnnouncementController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('documents', DocumentController::class);
Route::resource('events', EventController::class);
Route::resource('achievements', AchievementController::class);
Route::resource('extracurriculars', ExtracurricularController::class);
Route::resource('galleries', GalleryController::class);
Route::resource('videos', VideoController::class);
