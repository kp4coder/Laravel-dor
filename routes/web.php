<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/', [MainController::class, 'index']);
// Route::any('book-dor', [MainController::class, 'bookDor']);
// Route::any('bookmail/{bid}', [MainController::class, 'bookmail']);
// Route::any('{url}', [MainController::class, 'page']);

