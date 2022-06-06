<?php

use App\Http\Controllers\LinksController;
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

// Redirect to original url by hash
Route::get('/{hash}', [LinksController::class, 'process']);

// Redirect to original url by hash from folder
Route::get('url/{hash}', [LinksController::class, 'process']);

// Any other routes loading frontend
Route::get('{any}', function () {
    return view('app');
})->where('any', '.*');
