<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Public\AcademicController;
use App\Http\Controllers\Public\AnnouncementController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\DownloadController;
use App\Http\Controllers\Public\EventController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Public\SpmbController;
use App\Http\Controllers\Public\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Web Routes - SMAN 24 Bandung
|--------------------------------------------------------------------------
*/

// SEO & Sitemap Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

// Rate limited public routes (endpoints with search/filter capabilities)
Route::middleware('throttle:60,1')->group(function () {
    // News & Articles Routes
    Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
    Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');
    Route::post('/berita/{slug}/komentar', [NewsController::class, 'storeComment'])->name('news.comments.store');

    // Informasi Aliases (for direct Indonesian URL navigation)
    Route::get('/informasi', [NewsController::class, 'index']);
    Route::get('/informasi/{slug}', [NewsController::class, 'show']);
    Route::post('/informasi/{slug}/komentar', [NewsController::class, 'storeComment']);

    // Announcements Routes
    Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/pengumuman/{slug}', [AnnouncementController::class, 'show'])->name('announcements.show');

    // Agenda / Events Routes
    Route::get('/agenda', [EventController::class, 'index'])->name('events.index');
    Route::get('/agenda/{slug}', [EventController::class, 'show'])->name('events.show');

    // Academic & Teachers Directory Routes
    Route::get('/akademik/guru', [AcademicController::class, 'teachers'])->name('academic.teachers');
    Route::get('/akademik/kalender', [AcademicController::class, 'calendar'])->name('academic.calendar');

    // Student & Extracurriculars Routes
    Route::get('/kesiswaan/osis', [StudentController::class, 'osis'])->name('student.osis');
    Route::get('/kesiswaan/ekstrakurikuler', [StudentController::class, 'extracurriculars'])->name('student.extracurriculars');
    Route::get('/kesiswaan/prestasi', [StudentController::class, 'achievements'])->name('student.achievements');

    // Media & Gallery Routes
    Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/galeri/{slug}', [GalleryController::class, 'show'])->name('gallery.show');

    // Downloads & Documents Routes
    Route::get('/download', [DownloadController::class, 'index'])->name('download.index');

    // SPMB Routes
    Route::get('/spmb/pendaftar', [SpmbController::class, 'pendaftar'])->name('spmb.pendaftar');
    Route::get('/spmb/daftar-ulang', [SpmbController::class, 'daftarUlang'])->name('spmb.daftar_ulang');

    // Contact Route
    Route::get('/kontak', [ContactController::class, 'index'])->name('contact');
});

Route::post('/download/{document}', [DownloadController::class, 'download'])->name('download.file')->middleware('throttle:20,1');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');

// Logout is POST-only to prevent CSRF logout attacks via crafted GET links
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
Route::post('/logout', fn () => redirect()->route('admin.logout'));
