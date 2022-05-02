<?php 

use App\Http\Controllers\Auth\{
    LoginController as A_LoginController
};

Route::as('auth.')->group(function () {
    Route::get('/login', [A_LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [A_LoginController::class, 'doLogin'])->name('login.post');
    Route::get('/logout', [A_LoginController::class, 'logout'])->name('logout');
});