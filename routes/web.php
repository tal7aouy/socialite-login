<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// login by  google account
Route::get('login/google', [AuthenticatedSessionController::class,'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [AuthenticatedSessionController::class,'handleGoogleCallback']);
// login by  facebook account
Route::get('login/facebook', [AuthenticatedSessionController::class,'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthenticatedSessionController::class,'handleFacebookCallback']);
// login by  github account
Route::get('login/github', [AuthenticatedSessionController::class,'redirectToGithub'])->name('login.github');
Route::get('login/github/callback', [AuthenticatedSessionController::class,'handleGithubCallback']);
require __DIR__.'/auth.php';
