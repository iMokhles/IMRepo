<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes

    CRUD::resource('packages', 'PackageCrudController');
    CRUD::resource('depictions', 'DepictionCrudController');
    CRUD::resource('change_logs', 'ChangeLogCrudController');
    CRUD::resource('downloads', 'DownloadCrudController');
    CRUD::resource('reviews', 'ReviewCrudController');
    CRUD::resource('settings', 'SettingCrudController');

    Route::get('/delete/screenshot/{id}', 'DepictionCrudController@deleteScreenshot')->name('delete.screenshot');
    Route::get('/build_packages', 'RepoController@buildPackages');


}); // this should be the absolute last line of this file
