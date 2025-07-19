<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NameController;
use App\Http\Controllers\SurveyAdminController;
use App\Http\Controllers\SystemResourceController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/home', [HomeController::class, 'index']);

Route::get('/survey/{slug}', [NameController::class, 'showList']);
Route::post('/survey/{slug}/savename', [NameController::class, 'saveName']);
Route::post('/survey/{slug}/savenames', [NameController::class, 'saveNames']);
Route::post('/survey/{slug}/savealtname', [NameController::class, 'saveAltName']);

Route::post('/create', [HomeController::class, 'create']);

Route::get('/admin/{survey}/options/', [SurveyAdminController::class, 'showOptions']);
Route::get('/admin/{survey}/download/', [SurveyAdminController::class, 'download']);

Route::post('/admin/{survey}/changestart/', [SurveyAdminController::class, 'changeStart']);
Route::post('/admin/{survey}/changeend/', [SurveyAdminController::class, 'changeEnd']);
Route::post('/admin/{survey}/adduniversity/', [SurveyAdminController::class, 'addUniversity']);
Route::post('/admin/{survey}/deleteuniversity/', [SurveyAdminController::class, 'deleteUniversity']);
Route::post('/admin/{survey}/addinstructor/', [SurveyAdminController::class, 'addInstructor']);
Route::post('/admin/{survey}/deleteinstructor/', [SurveyAdminController::class, 'deleteInstructor']);
Route::post('/admin/{survey}/addinstructions/', [SurveyAdminController::class, 'addInstructions']);

Route::get('ram_cpu', [SystemResourceController::class, 'total_ram_cpu']);