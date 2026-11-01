<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;

Route::get('/homepage', function () {
    return view('homepage.home');
})->name('homepage');

Route::get('/flight/schedule', function () {
    return view('flight.schedule');
})->name('flight.schedule');

// Flight Routes
Route::get('/flights', [FlightController::class, 'index'])->name('flights.index');
Route::get('/flights/search', [FlightController::class, 'search'])->name('flights.search');
Route::get('/flights/show/{id}', [FlightController::class, 'show'])->name('flights.show');
Route::get('/api/airports', [FlightController::class, 'getAirports'])->name('api.airports');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);