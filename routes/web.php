<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controller;
use App\Http\Controllers\CheckController;
use App\Http\controllers\DashboardController;

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

Route::get('/Dashboard',[DashboardController::class, 'index']);
Route::get('/Load_task',[DashboardController::class, 'Load_task']);
Route::post('/Search',[DashboardController::class, 'jSearchTicket']);
Route::get('/Check',[CheckController::class, 'index']);
Route::post('/createTask',[CheckController::class, 'createTask']);
Route::post('/retrieveToken',[CheckController::class, 'retrieveToken']);
Route::post('/saveMyIP',[CheckController::class, 'saveMyIP']);
Route::post('/retrieveNDByIP',[CheckController::class, 'retrieveNDByIP']);
Route::post('/retrieveIPByND',[CheckController::class, 'retrieveIPByND']);
Route::post('/retrieveUkur',[CheckController::class, 'retrieveUkur']);
Route::post('/retrievePCRF',[CheckController::class, 'retrievePCRF']);
Route::post('/retrieveSpeed',[CheckController::class, 'retrieveSpeed']);
Route::post('/retrieveCloseAuto',[CheckController::class, 'retrieveCloseAuto']);

