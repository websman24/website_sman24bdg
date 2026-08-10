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
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
| Prefix: /admin
| Name prefix: admin.
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', fn() => redirect()->route('admin.dashboard'));

// Settings & Profiles
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
Route::resource('profiles', SchoolProfileController::class)->only(['index', 'update']);

// User Management Routes
Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete'])->name('users.bulk_delete');
Route::resource('users', UserController::class);

// CMS Resource & Bulk Delete Routes
Route::post('/news/bulk-delete', [NewsController::class, 'bulkDelete'])->name('news.bulk_delete');
Route::resource('news-categories', NewsCategoryController::class);
Route::resource('news', NewsController::class);

Route::post('/announcements/bulk-delete', [AnnouncementController::class, 'bulkDelete'])->name('announcements.bulk_delete');
Route::resource('announcements', AnnouncementController::class);

Route::post('/events/bulk-delete', [EventController::class, 'bulkDelete'])->name('events.bulk_delete');
Route::resource('events', EventController::class);

Route::post('/teachers/bulk-delete', [TeacherController::class, 'bulkDelete'])->name('teachers.bulk_delete');
Route::get('/teachers/template', [TeacherController::class, 'downloadTemplate'])->name('teachers.template');
Route::post('/teachers/import', [TeacherController::class, 'import'])->name('teachers.import');
Route::resource('teachers', TeacherController::class);

Route::get('/staff/template', [StaffController::class, 'downloadTemplate'])->name('staff.template');
Route::post('/staff/import', [StaffController::class, 'import'])->name('staff.import');
Route::resource('staff', StaffController::class);

Route::resource('sliders', SliderController::class);
Route::resource('documents', DocumentController::class);
Route::resource('achievements', AchievementController::class);
Route::resource('extracurriculars', ExtracurricularController::class);

Route::post('/galleries/{gallery}/items', [GalleryController::class, 'addItem'])->name('galleries.items.add');
Route::delete('/galleries/{gallery}/items/{item}', [GalleryController::class, 'deleteItem'])->name('galleries.items.delete');
Route::post('/galleries/{gallery}/items/{item}/cover', [GalleryController::class, 'setCover'])->name('galleries.items.cover');
Route::resource('galleries', GalleryController::class);
Route::resource('videos', VideoController::class);
