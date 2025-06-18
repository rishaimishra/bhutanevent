<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\LiveSessionController;
use App\Http\Controllers\Admin\LiveQuestionController;
use App\Http\Controllers\Admin\LivePollController;
use App\Http\Controllers\PollController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('live-sessions', LiveSessionController::class);
    Route::resource('live-questions', LiveQuestionController::class);
    Route::resource('live-polls', LivePollController::class);
    Route::get('live-polls/{livePoll}/results', [LivePollController::class, 'results'])->name('live-polls.results');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/polls/{livePoll}', [PollController::class, 'show'])->name('polls.show');
    Route::post('/polls/{livePoll}/vote', [PollController::class, 'vote'])->name('polls.vote');
});
