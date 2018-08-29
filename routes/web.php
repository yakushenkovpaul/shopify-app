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
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/proxy', function () {
    return response('Hello, world!')->withHeaders(['Content-Type' => 'application/liquid']);
 })->middleware('auth.proxy');

 Route::get('/page', 'WrapController@page')->name('page');

 /* Route::get('/wrap', 'WrapController@index')->name('wrap');
 Route::get('/wrap-addProduct', 'WrapController@addProduct')->name('wrap-addProduct'); */
