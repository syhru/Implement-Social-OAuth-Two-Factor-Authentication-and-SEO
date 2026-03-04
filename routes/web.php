<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\OtpController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Social Auth Routes
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

// OTP Routes (Must be logged in to view/verify OTP)
Route::middleware('auth')->group(function () {
    Route::get('/otp/verify', [OtpController::class, 'showVerifyForm'])->name('otp.verify.form');
    Route::post('/otp/verify', [OtpController::class, 'verify'])->name('otp.verify.submit');
    Route::post('/otp/resend', [OtpController::class, 'resend'])->name('otp.resend');
});

// Protected routes (Requires both auth and 2fa verification if enabled)
Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
