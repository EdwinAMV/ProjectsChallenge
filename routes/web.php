<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GithubAuthController;
use App\Http\Controllers\GoolgleAuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
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

// Rutas para la autenticación social
Route::get('/auth/redirect/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialAuthController::class, 'callback'])->name('social.callback');

Route::get('auth/google',[GoolgleAuthController::class,'redirect'])->name('google-auth');
Route::get('auth/google/call-back', [GoolgleAuthController::class,'callbackgoogle']);

Route::get('auth/github',[GithubAuthController::class,'redirect'])->name('github-auth');
Route::get('auth/github/call-back', [GithubAuthController::class,'callbackgithub']);

//VIEW DEL CALENDARIO
Route::view('/calendar', 'DEVCHALLENGE3/calendar')->name('calendar');

//RUTAS CRUD CALENDARIO
Route::get('/calendar', [EventController::class, 'showCalendar'])->middleware('auth')->name('calendar');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::put('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
Route::delete('/event/destroy/{id}', [EventController::class, 'destroy'])->name('event.destroy');

require __DIR__.'/auth.php';
