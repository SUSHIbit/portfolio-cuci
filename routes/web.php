<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomepageController as AdminHomepageController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\SocialLinkController;
use Illuminate\Support\Facades\Route;

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

// Public Portfolio Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Admin Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Homepage Management
    Route::get('/homepage', [AdminHomepageController::class, 'index'])->name('homepage.index');
    Route::put('/homepage', [AdminHomepageController::class, 'update'])->name('homepage.update');

    // About Page Management
    Route::get('/about', [AdminAboutController::class, 'index'])->name('about.index');
    Route::post('/about/experience', [AdminAboutController::class, 'storeExperience'])->name('about.experience.store');
    Route::put('/about/experience/{experience}', [AdminAboutController::class, 'updateExperience'])->name('about.experience.update');
    Route::delete('/about/experience/{experience}', [AdminAboutController::class, 'destroyExperience'])->name('about.experience.destroy');
    Route::post('/about/sections', [AdminAboutController::class, 'storeSection'])->name('about.sections.store');
    Route::put('/about/sections/{section}', [AdminAboutController::class, 'updateSection'])->name('about.sections.update');
    Route::delete('/about/sections/{section}', [AdminAboutController::class, 'destroySection'])->name('about.sections.destroy');
    Route::post('/about/sections/{section}/items', [AdminAboutController::class, 'storeSectionItem'])->name('about.sections.items.store');
    Route::put('/about/sections/items/{item}', [AdminAboutController::class, 'updateSectionItem'])->name('about.sections.items.update');
    Route::delete('/about/sections/items/{item}', [AdminAboutController::class, 'destroySectionItem'])->name('about.sections.items.destroy');

    // Projects Management
    Route::resource('projects', AdminProjectController::class);
    Route::delete('/projects/images/{image}', [AdminProjectController::class, 'deleteImage'])->name('projects.images.destroy');

    // Social Links Management
    Route::resource('social-links', SocialLinkController::class);

    // Contact Messages
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::patch('/contacts/{contact}/read', [AdminContactController::class, 'markAsRead'])->name('contacts.read');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
