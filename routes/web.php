<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\AdminIndexController;
use Illuminate\Support\Facades\Auth;

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

// PRIORITAS: Rute utama untuk admin - ini akan menangani /admin dan memprioritaskannya 
// karena routes/web.php dimuat sebelum routes/admin.php di RouteServiceProvider
Route::get('/admin', [AdminIndexController::class, 'index']);

// Rute untuk homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Public routes
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Ticket viewing and purchasing (for all logged-in users)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/purchase', [TicketController::class, 'purchase'])->name('tickets.purchase');
    
    // Transaction viewing (for all logged-in users)
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/my-transactions', [TransactionController::class, 'userTransactions'])->name('transactions.user');
    
    // My Tickets feature - show tickets purchased by the logged-in user
    Route::get('/my-tickets', [TicketController::class, 'userTickets'])->name('tickets.user');
    
    // Admin only routes
    Route::middleware(['admin'])->group(function () {
        // Artist management (admin only)
        Route::resource('artists', ArtistController::class)->except(['index', 'show']);
        
        // Event management (admin only)
        Route::resource('events', EventController::class)->except(['index', 'show']);
        
        // Ticket management (admin only)
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::patch('/tickets/{ticket}', [TicketController::class, 'update']);
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
        
        // Transaction management (admin only)
        Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });
});

require __DIR__.'/auth.php';
