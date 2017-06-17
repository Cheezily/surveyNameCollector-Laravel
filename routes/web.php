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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/create', 'HomeController@create')->name('create');

Route::get('/admin/{survey}/options/', 'SurveyAdminController@showOptions')->name('showOptions');
Route::post('/admin/{survey}/changestart/', 'SurveyAdminController@changeStart')->name('changeStart');
Route::post('/admin/{survey}/changeend/', 'SurveyAdminController@changeEnd')->name('changeEnd');


