<?php

use App\Http\Controllers\Dashboard\BranchesController;
use App\Http\Controllers\Dashboard\CaptainsController;
use App\Http\Controllers\Dashboard\StoresController;
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

Route::prefix('dashboard')->group(function (){
    Route::resource('stores', \App\Http\Controllers\Dashboard\StoresController::class);
    Route::post('/update-store-status', [StoresController::class, 'updateStatus'])->name('update-store-status');

    Route::resource('cities', \App\Http\Controllers\Dashboard\CitiesController::class);
    Route::resource('ranges', \App\Http\Controllers\Dashboard\RangesController::class);
    Route::resource('branches', \App\Http\Controllers\Dashboard\BranchesController::class);
    Route::post('/update-status', [BranchesController::class, 'updateStatus'])->name('update-status');
    Route::get('/search', [BranchesController::class , 'search'])->name('branches.search');

    Route::resource('/reason', \App\Http\Controllers\Dashboard\ReasonsController::class);
    Route::resource('/sizes', \App\Http\Controllers\Dashboard\SizesController::class);
    Route::resource('/type_store', \App\Http\Controllers\Dashboard\StoreTypesController::class);
    Route::resource('/captains', \App\Http\Controllers\Dashboard\CaptainsController::class);
    Route::post('/update-captain-status', [CaptainsController::class, 'updateStatus'])->name('update-captain-status');


});