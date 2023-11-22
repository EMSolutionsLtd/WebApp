<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\TempImageController;
use App\Http\Controllers\admin\BlogController as AdminBlogController;
use App\Http\Controllers\admin\FaqController as AdminFaqController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\SettingsController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/about-us', [HomeController::class, 'about'])->name('about');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/services', [ServicesController::class, 'index']);
Route::get('/services/detail/{id}', [ServicesController::class, 'detail']);
Route::get('/faq', [FaqController::class, 'index']);
Route::get('/blog', [BlogController::class, 'index'])->name('blog.front');
Route::get('/blog/{id}', [BlogController::class, 'detail'])->name('blog-detail');
Route::post('/save-comment', [BlogController::class, 'saveComment'])->name('save.comment');
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/send-email', [ContactController::class, 'sendEmail'])->name('sendContactEmail');



Route::prefix('admin')->group(function () {

    // Set the 'admin.guest' in Kernel.php
    Route::group(['middleware' => 'admin.guest'], function() {
        // Here we will define guest route, that is, before login to the admin panel
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/login', [AdminLoginController::class, 'authenticate'])->name('admin.auth');
    });

    // Set the 'admin.auth' in Kernel.php
    Route::group(['middleware' => 'admin.auth'], function() {
        // Here we will define password protected routes, that is, after login to the admin panel

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create.form');
        Route::post('/services/create', [ServiceController::class, 'save'])->name('services.create');
        Route::get('/services', [ServiceController::class, 'index'])->name('serviceList');
        Route::get('/services/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
        Route::post('/services/edit/{id}', [ServiceController::class, 'update'])->name('services.edit.update');
        Route::post('/services/delete/{id}', [ServiceController::class, 'delete'])->name('services.delete');

        Route::post('/temp/upload', [TempImageController::class, 'upload'])->name('tempUpload');

        // Blog
        Route::get('/blog/create', [AdminBlogController::class, 'create'])->name('blog.create.form');
        Route::post('/blog/create', [AdminBlogController::class, 'save'])->name('blog.save');
        Route::get('/blog', [AdminBlogController::class, 'index'])->name('blogList');
        Route::get('/blog/edit/{id}', [AdminBlogController::class, 'edit'])->name('blog.edit');
        Route::post('/blog/edit/{id}', [AdminBlogController::class, 'update'])->name('blog.update');
        Route::post('/blog/delete/{id}', [AdminBlogController::class, 'delete'])->name('blog.delete');

        //Faq
        Route::get('/faq', [AdminFaqController::class, 'index'])->name('faqList');
        Route::get('/faq/create', [AdminFaqController::class, 'create'])->name('faq.create');
        Route::post('/faq/save', [AdminFaqController::class, 'save'])->name('faq.save');
        Route::get('/faq/edit/{id}', [AdminFaqController::class, 'edit'])->name('faq.edit');
        Route::post('/faq/edit/{id}', [AdminFaqController::class, 'update'])->name('faq.update');
        Route::post('/faq/delete/{id}', [AdminFaqController::class, 'delete'])->name('faq.delete');

        // Page Routes
        Route::get('/page/create', [PageController::class, 'create'])->name('page.create.form');
        Route::post('/page/create', [PageController::class, 'save'])->name('page.save');
        Route::get('/pages', [PageController::class, 'index'])->name('pageList');
        Route::get('/page/edit/{id}', [PageController::class, 'edit'])->name('page.edit');
        Route::post('/page/edit/{id}', [PageController::class, 'update'])->name('page.update');
        Route::post('/page/delete/{id}', [PageController::class, 'delete'])->name('page.delete');

        Route::post('/page/deleteImage', [PageController::class, 'deleteImage'])->name('page.deleteImage');

        // Settings Routes
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'save'])->name('settings.save');
    });
});
