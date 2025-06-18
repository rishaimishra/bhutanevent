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
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\TributeController;
use App\Http\Controllers\Admin\TimelineEntryController;
use App\Http\Controllers\Admin\AudioClipController;
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
    
    Route::get('feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('feedback/{feedback}', [FeedbackController::class, 'show'])->name('feedback.show');
    Route::delete('feedback/{feedback}', [FeedbackController::class, 'destroy'])->name('feedback.destroy');

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::get('notifications/{notification}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
    Route::put('notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('notifications/{notification}/send-now', [NotificationController::class, 'sendNow'])->name('notifications.send-now');

    // Tribute routes
    Route::get('tributes', [TributeController::class, 'index'])->name('tributes.index');
    Route::get('tributes/{tribute}', [TributeController::class, 'show'])->name('tributes.show');
    Route::post('tributes/{tribute}/approve', [TributeController::class, 'approve'])->name('tributes.approve');
    Route::post('tributes/{tribute}/reject', [TributeController::class, 'reject'])->name('tributes.reject');
    Route::delete('tributes/{tribute}', [TributeController::class, 'destroy'])->name('tributes.destroy');

    // Timeline Routes
    Route::resource('timeline', TimelineEntryController::class);

    // Audio Clips Routes
    Route::resource('audio', AudioClipController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/polls/{livePoll}', [PollController::class, 'show'])->name('polls.show');
    Route::post('/polls/{livePoll}/vote', [PollController::class, 'vote'])->name('polls.vote');
});
