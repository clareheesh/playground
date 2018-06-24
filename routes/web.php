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

//Route::get('/', 'HomeController@index');
Route::get('/', 'DollController@index');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('dolls/all', 'DollController@all');
Route::post('dolls/{id}/increase', 'DollController@increase');
Route::post('dolls/{id}/decrease', 'DollController@decrease');
Route::resource('dolls', 'DollController', ['except' => ['create', 'edit']]);

//Route::resource('link', 'LinkController')->only(['create']);