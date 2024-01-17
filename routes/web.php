<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\Auth\CreateAccountController;
use App\Http\Controllers\Auth\RegisterUser;
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

// Auth::routes(['register' => false]);

//__Login & Logout__//

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', CheckSessionExpiration::class]);
// Route::get('password-edit',RegisterUser::class,'user_edit');

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


//keepAlive
// Route::get('/keep-alive', [StockReportController::class,'keepAlive']);

//Register New User
Route::resource('users', RegisterUser::class);
// Route::get('user-edit/{user_id}',RegisterUser::class,'user_edit');
// Route::post('user-update/',RegisterUser::class,'update');
// Route::get('user-delete/{user_id}',RegisterController,'user_delete');
