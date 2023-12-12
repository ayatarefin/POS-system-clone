<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Middleware\CheckSessionExpiration;

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

//__Login & Logout__//
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', CheckSessionExpiration::class])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', CheckSessionExpiration::class])->name('dashboard');

Route::get('/logout', function () {
    Auth::logout();
    // Manually regenerate the session to update the CSRF token
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->middleware(['auth',CheckSessionExpiration::class]);

//current stock
Route::get('/search-stock', [StockReportController::class, 'searchStock'])->middleware(['auth',CheckSessionExpiration::class]);
Route::get('/stock-reports', [StockReportController::class, 'currentStock'])->name('currentStock')->middleware(['auth',CheckSessionExpiration::class]);
