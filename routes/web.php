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

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/insertData','HomeController@Ajax');
Route::get('/invoices','HomeController@invoices');

Route::get('invoices/{id}','HomeController@convert');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
