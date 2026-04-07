<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', 'HomeController@index')->name('home');
Route::post('/search', 'HomeController@search')->name('home.search');

Auth::routes(['register' => false]);

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('users', 'UserController')->only(['index', 'create', 'store', 'edit', 'update']);

    Route::resource('orders', 'OrderController')->except(['destroy']);
    Route::delete('/orders/{order}', 'OrderController@destroy')->name('orders.destroy');
    Route::get('/orders-archived', 'OrderController@archived')->name('orders.archived');
    Route::patch('/orders/{order}/restore', 'OrderController@restore')->name('orders.restore');
});
