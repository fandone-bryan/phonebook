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

Route::get('/login', function () {
    return view('login');
});

Route::post('/auth', 'SessionController@store');
Route::get('/logout', 'SessionController@destroy');

Route::post('/users', 'UserController@store');


Route::group(['middleware' => 'auth'], function () use ($router) { 
    Route::get('/', 'CustomerController@index');    
    
    Route::get('/clientes/criar', 'CustomerController@create');    
    Route::post('/clientes', 'CustomerController@store');  
    
    Route::get('/clientes/{customerId}/telefones', 'PhoneController@index');
    Route::post('/telefones', 'PhoneController@store');
    Route::put('/telefones/{id}', 'PhoneController@update');
    Route::delete('/telefones/{id}', 'PhoneController@destroy');
});
