<?php

use App\Enums\RoutesName;
use App\Http\Controllers\ChequeAiController;
use App\Http\Controllers\ChequeController;
use App\Http\Controllers\ChequeLogsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web RoutesName
|--------------------------------------------------------------------------
|
| Here is where you can register web RoutesName for your application. These
| RoutesName are loaded by the RoutesNameerviceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require 'testRoute.php';

// Route::resource('posts', PostController::class);



/**
 * User Route
 */
Route::group(['middleware' => ['auth', 'restric.id']], function () {

    Route::resource('cheque', ChequeController::class);
    Route::resource('client', ClientController::class);
    Route::resource('logs', ChequeLogsController::class);
    Route::resource('transaction', TransactionController::class);

    Route::get('/clients/search', [ClientController::class, 'search'])->name('clients.search');

    # Read cheque data by ai
    Route::post('/cheques/read-image', [ChequeAiController::class, 'readImage'])->name('cheques.read-image');
});


Route::group(
    ['middleware' => ['guest']],
    function () {
        // User login
        Route::get(RoutesName::Login->value, [LoginController::class, 'loginForm'])->name('login');
        Route::post(RoutesName::Login->value, [LoginController::class, 'login']);
    }
);
