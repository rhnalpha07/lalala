<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ArtistController as AdminArtistController;
use App\Http\Middleware\AdminMiddleware;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
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
    // Artist management
    Route::resource('artists', ArtistController::class)->except(['index', 'show']);
    
    // Event management
    Route::resource('events', EventController::class)->except(['index', 'show']);
    
    // Ticket management
    Route::resource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/purchase', [TicketController::class, 'purchase'])->name('tickets.purchase');
    
    // Transaction management
    Route::resource('transactions', TransactionController::class)->only(['index', 'show', 'create', 'store']);
    Route::get('/my-transactions', [TransactionController::class, 'userTransactions'])->name('transactions.user');
});

// Admin routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Events Management
    Route::resource('events', AdminEventController::class);
    
    // Artists Management
    Route::resource('artists', AdminArtistController::class);
});

require __DIR__.'/auth.php';
