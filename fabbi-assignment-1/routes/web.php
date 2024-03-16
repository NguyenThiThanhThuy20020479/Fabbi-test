<?php

use App\Http\Controllers\DishesController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::controller(DishesController::class)->group(function(){
    Route::get('/step_1', 'step_1')->name('step_1');
    Route::post('/step_2', 'step_2')->name('step_2');
    Route::post('/step_3', 'step_3')->name('step_3');
});
