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




Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('Dashboard');
    Route::get('/home', 'HomeController@index')->name('Dashboard');
    

    //Resigned Employee
    Route::get('/resigned-employees','ResignController@index')->name('Resigned');
    Route::get('/upload','ResignController@upload')->name('Upload Resigned');
    Route::post('/upload','ResignController@store')->name('Upload Resigned');
});

