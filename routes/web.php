<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ControlController;
use App\Http\Controllers\ListeController;
use App\Http\Controllers\PanoController;
use App\Models\Pano;
use App\Models\User;
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
    if (Auth::guest())
        return view('auth.login');
    else
        return redirect()->route('home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('liste', ListeController::class);
    Route::resource('card', CardController::class);
    Route::resource('pano', PanoController::class);
    Route::post('userSetPanos', [PanoController::class, 'userSetPanos'])->name('userSetPanos');
    Route::resource('control', ControlController::class);
    Route::post('controlCheck', [ControlController::class, 'check'])->name('control.check');
    Route::get('uyeler', [HomeController::class, 'users'])->name('users');
});

