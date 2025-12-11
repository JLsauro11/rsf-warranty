<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Rs8Controller;
use App\Http\Controllers\SRFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AccountController;
//use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductNameController;
use App\Http\Controllers\CSRRS8Controller;
use App\Http\Controllers\CSRSRFController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home.index'); // or your desired view
})->middleware(['auth', 'role:admin']); // restrict access as needed


Route::controller(RegistrationController::class)->group(function() {
    // Show form
    Route::match(['post', 'get'],'registration', 'registration')->name('registration');
    Route::get('products/{productId}', 'getProductNames')->name('getProductNames');
});

Route::controller(AuthController::class)->group( function() {
    Route::match(['post', 'get'], 'login', 'login')->name('login');
    Route::post('auth/logout', 'logout')->name('logout');
    Route::get( 'forgot-password', 'forgot_password')->name('forgot-password');
    Route::post( 'verify/submit', 'verify_submit')->name('verify-submit');
    Route::match( ['post','get'], 'change-password', 'change_password_submit')->name('change-password-submit');
});

Route::group(['prefix' => 'admin/account', 'as' => 'admin.account.', 'middleware' => ['auth', 'role:admin']], function(){
    Route::match(['post', 'get'], 'update-account', [AccountController::class, 'update_account'])->name('update');
});

Route::group(['prefix' => 'csr_rs8/account', 'as' => 'csr_rs8.account.', 'middleware' => ['auth', 'role:csr_rs8']], function(){
    Route::match(['post', 'get'], 'update-account', [AccountController::class, 'update_account'])->name('update');
});

Route::group(['prefix' => 'csr_srf/account', 'as' => 'csr_srf.account.', 'middleware' => ['auth', 'role:csr_srf']], function(){
    Route::match(['post', 'get'], 'update-account', [AccountController::class, 'update_account'])->name('update');
});


Route::controller(HomeController::class)->middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/admin', 'index')->name('admin.index');
    Route::get('/admin/accountDisplay', 'accountDisplay')->name('admin.accountDisplay');
});

Route::controller(CSRRS8Controller::class)->middleware(['auth', 'role:csr_rs8'])->group(function() {
    Route::get('/csr_rs8', 'index')->name('csr_rs8.index');
    Route::get('/csr_rs8/accountDisplay', 'accountDisplay')->name('csr_rs8.accountDisplay');
});

Route::controller(CSRSRFController::class)->middleware(['auth', 'role:csr_srf'])->group(function() {
    Route::get('/csr_srf', 'index')->name('csr_srf.index');
    Route::get('/csr_srf/accountDisplay', 'accountDisplay')->name('csr_srf.accountDisplay');
});

Route::group(['prefix' => 'product-name', 'as' => 'product-name.', 'middleware' => ['auth', 'role:admin']], function(){
    Route::controller(ProductNameController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
        Route::get('trash', 'trash')->name('trash');
        Route::post('restore', 'restore')->name('restore');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update/{id}', 'update')->name('update');
        Route::post('delete', 'delete')->name('delete');

    });
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'role:admin']], function(){
    Route::controller(UserController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
//        Route::get('trash', 'trash')->name('trash');
        Route::post('restore', 'restore')->name('restore');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update/{id}', 'update')->name('update');
        Route::post('delete', 'delete')->name('delete');

    });
});

Route::group(['prefix' => 'admin/rs8', 'as' => 'admin.rs8.', 'middleware' => ['auth', 'role:admin']], function(){
    Route::controller(Rs8Controller::class)->group(function () {
        Route::get('', 'index')->name('index'); // accessible by both admin and csr_rs8

        // Restrict these routes only for admins by applying middleware in controller or here:
        Route::post('update-status', 'update_status')->name('update-status');
        Route::post('delete', 'delete')->name('delete');
    });
});

Route::group(['prefix' => 'csr_rs8/rs8', 'as' => 'csr_rs8.rs8.', 'middleware' => ['auth', 'role:csr_rs8']], function(){
    Route::controller(Rs8Controller::class)->group(function () {
        Route::get('', 'index')->name('index');
    });
});

Route::group(['prefix' => 'admin/srf', 'as' => 'admin.srf.', 'middleware' => ['auth', 'role:admin']], function(){
    Route::controller(SRFController::class)->group(function () {
        Route::get('', 'index')->name('index'); // accessible by both admin and csr_srf

        Route::post('update-status', 'update_status')->name('update-status')->middleware('role:admin');
        Route::post('delete', 'delete')->name('delete')->middleware('role:admin');
    });
});

Route::group(['prefix' => 'csr_srf/srf', 'as' => 'csr_srf.srf.', 'middleware' => ['auth', 'role:csr_srf']], function(){
    Route::controller(SRFController::class)->group(function () {
        Route::get('', 'index')->name('index');
    });
});

