<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TransactionController;
use Illuminate\Support\Facades\Auth;

// Group all admin routes with a prefix
Route::prefix('admin')->group(function () {
    // Guest routes for admin (login, register, etc)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'create'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'store']);
        
        Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('admin.register');
        Route::post('/register', [AuthController::class, 'register']);
        
        Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
        Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('admin.password.email');
        
        Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('admin.password.update');
    });

    // Protected admin routes
    Route::middleware(['auth:admin'])->name('admin.')->group(function () {
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
        
        // Main dashboard route - always use DashboardController
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Admin profile routes
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

        // Events Routes
        Route::resource('events', EventController::class);
        
        // Artists Routes
        Route::resource('artists', ArtistController::class);
        
        // User management
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('users.toggle-admin');
        
        // Ticket management
        Route::resource('tickets', TicketController::class);
        Route::post('/tickets/bulk-create', [TicketController::class, 'bulkCreate'])->name('bulk-create');
        Route::get('/tickets/export', [TicketController::class, 'export'])->name('tickets.export');
        
        // Transaction management
        Route::resource('transactions', TransactionController::class)->except(['create', 'store', 'edit', 'update']);
        Route::get('/transactions/export', [TransactionController::class, 'export'])->name('transactions.export');
        Route::put('/transactions/{transaction}/update-status', [TransactionController::class, 'updateStatus'])->name('update-status');
    });
}); 