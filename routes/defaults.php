<?php 

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function(){
    Route::view('/home', 'app.backend.admin.index', ['section' => '¡'.env('APP_NAME').', Bienvenido!'])->name('index');
});

Route::prefix('users')->as('users.')->middleware(['auth'])->group(function(){

});