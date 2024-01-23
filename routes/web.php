<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
//Home Pge
Route::get('/', [HomeController::class, 'index'])->name('index');



// Logout
// Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');

// //Profile
// Route::get('account/profile', [AccountController::class, 'profile'])->name('account.profile');

Route::group(['account'], function () {
    route::group(['middleware' => 'guest'], function () {
        // Account - registraion 
        Route::get('/account/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/account/registrationProcess', [AccountController::class, 'registrationProcess'])->name('account.registrationProcess');
        // Account - Login
        Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
        // Account - Login process
        Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    Route::group(['middleware' => 'auth'], function () {
        // Logout
        Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
        //Profile
        Route::get('account/profile', [AccountController::class, 'profile'])->name('account.profile');
        //updateUser
        Route::POST('account/updateUser', [AccountController::class, 'updateUser'])->name('account.updateUser');
        //update Profile pic
        Route::POST('account/updateprofilepic', [AccountController::class, 'updateprofilepic'])->name('account.updateprofilepic');
    });
});