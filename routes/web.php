<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Rs8Controller;
use App\Http\Controllers\SRFController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductNameController;

//Route::get('/', function () {
//    return view('home.index');
//});

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

Route::group(['prefix' => 'account', 'as' => 'account.', 'middleware' => 'is_admin'], function(){
    Route::controller(AccountController::class)->group(function () {
        Route::match( ['post','get'],'update-account', 'update_account')->name('update');
    });
});

Route::controller(HomeController::class)->middleware('is_admin')->group(function() {
    Route::get('/', 'index')->name('index');
    Route::get('accountDisplay', 'accountDisplay')->name('accountDisplay');
});

//Route::group(['prefix' => 'product', 'as' => 'product.', 'middleware' => 'is_admin'], function(){
//    Route::controller(ProductController::class)->group(function () {
//        Route::get('', 'index')->name('index');
//        Route::post('add', 'add')->name('add');
//    });
//});

Route::group(['prefix' => 'product-name', 'as' => 'product-name.', 'middleware' => 'is_admin'], function(){
    Route::controller(ProductNameController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
        Route::get('trash', 'trash')->name('trash');
        Route::post('restore', 'restore')->name('restore');
        Route::post('delete', 'delete')->name('delete');

    });
});

Route::group(['prefix' => 'rs8', 'as' => 'rs8.', 'middleware' => 'is_admin'], function(){
    Route::controller(Rs8Controller::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('update-status', 'update_status')->name('update-status');
        Route::post('delete', 'delete')->name('delete');
    });
});

Route::group(['prefix' => 'srf', 'as' => 'srf.', 'middleware' => 'is_admin'], function(){
    Route::controller(SRFController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::post('update-status', 'update_status')->name('update-status');
        Route::post('delete', 'delete')->name('delete');
    });
});

