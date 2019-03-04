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

Route::get('/', 'HomeController@index');


// Cloud

Route::get('/cloud/screenshots/{id}/{name}', 'DepictionController@getScreenshot');
Route::get('/cloud/screenshots/{id}/conversions/{name}', 'DepictionController@getScreenshot');

// AUTH Routes


// DEBIAN Routes
Route::get('/Release', 'RepoController@getRelease');
Route::get('/CydiaIcon', 'RepoController@getCydiaIcon');
Route::get('/CydiaIcon.png', 'RepoController@getCydiaIconPng');
Route::get('/Packages', 'PackagesController@getPackages');
Route::get('/Packages.bz2', 'PackagesController@generateBZipPackages');
Route::get('/Packages.gz', 'PackagesController@generateGzPackages');
Route::get('/debs/{packageHash}', 'PackagesController@getPackageFile');


// Depiction Routes
Route::get('/depiction/{package_hash}', 'DepictionController@getDepiction')->name('package.depiction');
Route::get('/depiction/{package_hash}/change', 'DepictionController@getChanges')->name('package.depiction.changes');
