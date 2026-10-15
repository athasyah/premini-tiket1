<?php

use App\Http\Controllers\TicketFeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

Auth::routes();
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:user'])->get('/user/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/transaction', [AdminController::class, 'transaction'])->name('transaction');

    Route::resources([
        'event' => EventController::class,
        'category' => CategoryController::class,
        'ticket' => TicketController::class,
        'fee' => FeeController::class,
        'ticket_fee' => TicketFeeController::class,
    ]);
    // Route::get('/categories-by-event/{event_id}', [CategoryController::class, 'getCategoriesByEvent']);
});

// Route::get('/get-ticket-categories/{event_id}', [TicketController::class, 'getCategories']);

Route::get('/buy-ticket/{event}', [TicketController::class, 'showPurchasePage'])->name('buy.ticket');

Route::middleware(['auth'])->group(function () {
    Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');
});

// Route::get('/check-login', function () {
//     return response()->json(['authenticated' => Auth::check(), 'user' => Auth::user()]);
// });

Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
// Route::get('/history', [OrderController::class, 'history'])->name('history');
Route::get('/purchase/{eventId}', [PurchaseController::class, 'show'])->name('purchase.show');
// Route::post('/calculate-fee', [OrderController::class, 'calculateFee']);

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/user/ticket/{id}', [UserController::class, 'ticketDetail'])->name('user.detail');
    // Route::get('/user/tickets', [UserController::class, 'tickets'])->name('user.tickets');
    // Route::get('/user/tickets/upcoming', [UserController::class, 'upcomingTickets'])->name('user.tickets.upcoming');
    // Route::get('/user/tickets/used', [UserController::class, 'usedTickets'])->name('user.tickets.used');
    // Route::get('/user/transactions', [UserController::class, 'transactions'])->name('user.transactions');
});
Route::get('/tickets', [LandingController::class, 'tickets'])->name('tickets');

