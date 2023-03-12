<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth', 'prefix' => 'clients'], function () {
    Route::get('/', 'ClientController@index')->name('clients.index');
    Route::get('/create', 'ClientController@create');
    Route::post('/', 'ClientController@store');
    Route::get('/{client}', 'ClientController@show')->name('clients.show');
    Route::delete('/{client}', 'ClientController@destroy');

    Route::get('/{client}/journals', 'JournalController@index');
    Route::get('/{client}/journals/create', 'JournalController@create')->name('clients.journals.create');
    Route::post('/{client}/journals', 'JournalController@store')->name('clients.journals.store');
    Route::delete('/{client}/journals/{journal}', 'JournalController@destroy');
});
