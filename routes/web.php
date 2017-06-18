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

Route::get('/home', 'HomeController@index');

Route::get('/survey/{slug}', 'NameController@showList');

Route::post('/create', 'HomeController@create');

Route::get('/admin/{survey}/options/', 'SurveyAdminController@showOptions');
Route::post('/admin/{survey}/changestart/', 'SurveyAdminController@changeStart');
Route::post('/admin/{survey}/changeend/', 'SurveyAdminController@changeEnd');
Route::post('/admin/{survey}/adduniversity/', 'SurveyAdminController@addUniversity');
Route::post('/admin/{survey}/deleteuniversity/', 'SurveyAdminController@deleteUniversity');
Route::post('/admin/{survey}/addinstructor/', 'SurveyAdminController@addInstructor');
Route::post('/admin/{survey}/deleteinstructor/', 'SurveyAdminController@deleteInstructor');
Route::post('/admin/{survey}/addinstructions/', 'SurveyAdminController@addInstructions');


