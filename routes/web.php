<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application.
| Last Updated: 2025-06-03 08:39:01 UTC by Guram-jajanidze
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile & Settings
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('update-password');
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('delete-avatar');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::patch('/settings', [ProfileController::class, 'updateSettings'])->name('update-settings');
    });
    
    // Books Management
    Route::resource('books', BookController::class);
    Route::prefix('books')->name('books.')->group(function () {
        Route::get('/{book}/export', [BookController::class, 'export'])->name('export');
        Route::post('/bulk-import', [BookController::class, 'bulkImport'])->name('bulk-import');
        Route::get('/{book}/history', [BookController::class, 'history'])->name('history');
    });
    
    // Authors Management
    Route::resource('authors', AuthorController::class);
    Route::prefix('authors')->name('authors.')->group(function () {
        Route::get('/{author}/books', [AuthorController::class, 'books'])->name('books');
        Route::get('/{author}/export', [AuthorController::class, 'export'])->name('export');
    });
    
    // Categories Management
    Route::resource('categories', CategoryController::class);
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/{category}/books', [CategoryController::class, 'books'])->name('books');
        Route::get('/export/{format}', [CategoryController::class, 'export'])->name('export');
    });
    
    // Reservations Management
    Route::resource('reservations', ReservationController::class)->except(['edit', 'update', 'destroy']);
    Route::prefix('reservations')->name('reservations.')->group(function () {
        // User Actions
        Route::post('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cancel');
        Route::get('/{reservation}/edit', [ReservationController::class, 'edit'])->name('edit');
        Route::patch('/{reservation}/notes', [ReservationController::class, 'updateNotes'])->name('update-notes');
        
        // Librarian Actions
        Route::middleware(['role:admin,librarian'])->group(function () {
            Route::post('/{reservation}/fulfill', [ReservationController::class, 'fulfill'])->name('fulfill');
            Route::post('/mark-expired', [ReservationController::class, 'markExpired'])->name('mark-expired');
            Route::get('/queue/{book}', [ReservationController::class, 'queue'])->name('queue');
            Route::get('/export/{format}', [ReservationController::class, 'export'])->name('export');
            Route::post('/bulk-cancel', [ReservationController::class, 'bulkCancel'])->name('bulk-cancel');
        });
    });
    
    // Borrowings Management
    Route::resource('borrowings', BorrowingController::class)->except(['edit', 'update', 'destroy']);
    Route::prefix('borrowings')->name('borrowings.')->group(function () {
        Route::post('/{borrowing}/return', [BorrowingController::class, 'return'])->name('return');
        Route::post('/{borrowing}/renew', [BorrowingController::class, 'renew'])->name('renew');
        Route::post('/{borrowing}/pay-fine', [BorrowingController::class, 'payFine'])->name('pay-fine');
        Route::get('/overdue', [BorrowingController::class, 'overdue'])->name('overdue');
        Route::get('/export/{format}', [BorrowingController::class, 'export'])->name('export');
        
        // Librarian Actions
        Route::middleware(['role:admin,librarian'])->group(function () {
            Route::post('/mark-overdue', [BorrowingController::class, 'markOverdue'])->name('mark-overdue');
            Route::post('/send-reminders', [BorrowingController::class, 'sendReminders'])->name('send-reminders');
            Route::post('/bulk-return', [BorrowingController::class, 'bulkReturn'])->name('bulk-return');
        });
    });
    
    // User Management (Admin/Librarian only)
    Route::middleware(['role:admin,librarian'])->group(function () {
        Route::resource('users', UserController::class);
        Route::prefix('users')->name('users.')->group(function () {
            Route::post('/{user}/activate', [UserController::class, 'activate'])->name('activate');
            Route::post('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
            Route::get('/{user}/borrowing-history', [UserController::class, 'borrowingHistory'])->name('borrowing-history');
            Route::get('/export/{format}', [UserController::class, 'export'])->name('export');
            Route::post('/bulk-import', [UserController::class, 'bulkImport'])->name('bulk-import');
        });
        
        // Admin Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'reports'])->name('dashboard');
            Route::get('/books', [BookController::class, 'reports'])->name('books');
            Route::get('/borrowings', [BorrowingController::class, 'reports'])->name('borrowings');
            Route::get('/reservations', [ReservationController::class, 'reports'])->name('reservations');
            Route::get('/users', [UserController::class, 'reports'])->name('users');
        });
    });
    
    // Search & Global Actions
    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/global', [DashboardController::class, 'globalSearch'])->name('global');
        Route::get('/books', [BookController::class, 'search'])->name('books');
        Route::get('/authors', [AuthorController::class, 'search'])->name('authors');
        Route::get('/users', [UserController::class, 'search'])->name('users');
    });
    
    // Quick Actions API Routes for AJAX
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/books/{book}/availability', [BookController::class, 'checkAvailability'])->name('books.availability');
        Route::get('/users/{user}/borrowing-status', [UserController::class, 'borrowingStatus'])->name('users.borrowing-status');
        Route::get('/reservations/queue-status/{book}', [ReservationController::class, 'queueStatus'])->name('reservations.queue-status');
        Route::post('/notifications/mark-read', [DashboardController::class, 'markNotificationsRead'])->name('notifications.mark-read');
    });
});

// Authentication Routes
require __DIR__.'/auth.php';