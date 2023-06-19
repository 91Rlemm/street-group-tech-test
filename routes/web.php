<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[\App\Http\Controllers\PageController::class,'index'])
    ->name('csv.upload');

Route::post('/process',[\App\Http\Controllers\PageController::class,'process'])
    ->name('csv.process');

Route::get('/processed',[\App\Http\Controllers\PageController::class,'complete'])
    ->name('csv.processed');
