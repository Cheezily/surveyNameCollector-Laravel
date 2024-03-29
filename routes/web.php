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
Route::post('/survey/{slug}/savename', 'NameController@saveName');
Route::post('/survey/{slug}/savenames', 'NameController@saveNames');
Route::post('/survey/{slug}/savealtname', 'NameController@saveAltName');

Route::post('/create', 'HomeController@create');

Route::get('/admin/{survey}/options/', 'SurveyAdminController@showOptions');
Route::get('/admin/{survey}/download/', 'SurveyAdminController@download');

Route::post('/admin/{survey}/changestart/', 'SurveyAdminController@changeStart');
Route::post('/admin/{survey}/changeend/', 'SurveyAdminController@changeEnd');
Route::post('/admin/{survey}/adduniversity/', 'SurveyAdminController@addUniversity');
Route::post('/admin/{survey}/deleteuniversity/', 'SurveyAdminController@deleteUniversity');
Route::post('/admin/{survey}/addinstructor/', 'SurveyAdminController@addInstructor');
Route::post('/admin/{survey}/deleteinstructor/', 'SurveyAdminController@deleteInstructor');
Route::post('/admin/{survey}/addinstructions/', 'SurveyAdminController@addInstructions');

Route::get('ram_cpu', 'SystemResourceController@total_ram_cpu');