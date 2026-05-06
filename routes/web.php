<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FlightController;
use App\Http\Controllers\Admin\AirlineController;
use App\Http\Controllers\Admin\AirportController;
use App\Http\Controllers\Admin\AirplaneController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('flights.search');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer routes
Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
});

// Booking routes
Route::middleware('auth')->prefix('bookings')->name('bookings.')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/create', [BookingController::class, 'create'])->name('create');
    Route::post('/', [BookingController::class, 'store'])->name('store');
    Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
    Route::get('/{booking}/payment', [BookingController::class, 'payment'])->name('payment');
    Route::post('/{booking}/payment', [BookingController::class, 'processPayment'])->name('payment.process');
    Route::get('/{booking}/waiting', [BookingController::class, 'waitingPayment'])->name('waitingPayment');
    Route::post('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('role:admin,manager,staff');

    // Hanya Admin
    Route::middleware('admin')->group(function () {
        Route::resource('airlines', AirlineController::class);
        Route::resource('airports', AirportController::class);
        Route::resource('users', UserController::class);
    });

    // Hanya Manager
    Route::middleware('manager')->group(function () {
        Route::resource('airplanes', AirplaneController::class);
        Route::get('/airlines/{airline}/airplanes', [FlightController::class, 'getAirplanes'])->name('airlines.airplanes');
        Route::resource('flights', FlightController::class);
        
        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export/csv', [\App\Http\Controllers\Admin\ReportController::class, 'exportCsv'])->name('reports.exportCsv');
        Route::get('/reports/export/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'printPdf'])->name('reports.exportPdf');
    });

    // Hanya Staff
    Route::middleware('staff')->group(function () {
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::put('/bookings/{booking}/verify', [AdminBookingController::class, 'verifyPayment'])->name('bookings.verify');
        Route::put('/bookings/{booking}/reject', [AdminBookingController::class, 'rejectPayment'])->name('bookings.reject');

        Route::get('/offline-bookings/create', [\App\Http\Controllers\Admin\OfflineBookingController::class, 'create'])->name('offline-bookings.create');
        Route::post('/offline-bookings', [\App\Http\Controllers\Admin\OfflineBookingController::class, 'store'])->name('offline-bookings.store');
    });
});
