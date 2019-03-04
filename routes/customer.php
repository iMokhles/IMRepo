<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('customer.login');
Route::post('login', 'Auth\LoginController@login')->name('customer.login');
Route::post('logout', 'Auth\LoginController@logout')->name('customer.logout');
Route::get('logout', 'Auth\LoginController@logout')->name('customer.logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('customer.register');
Route::post('register', 'Auth\RegisterController@register')->name('customer.register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('customer.password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('customer.password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('customer.password.reset');

// Dashboard Routes...
Route::get('/dashboard', 'DashboardController@index')->name('customer.dashboard');
Route::get('/', 'HomeController@index')->name('customer.welcome');
