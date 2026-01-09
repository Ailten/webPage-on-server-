<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// index (default page).
Route::get('/', function () {
    return view('index');
})->name('index');

Route::prefix('/login')
->name('login.')
->controller(UserController::class)
->middleware('guest')
->group(function () {

    // route to login-redirect, with twitch OAuth.
    Route::get('/twitch', 'loginTwitch')->name('twitch');

});

// route to logout.
Route::delete('/logout', [UserController::class, 'logout'])
->name('logout')
->middleware('auth');

// debug.
Route::get('/debug', function (Request $request) {

    // TODO: add a controller, to verify is loged and if it's an user who has permission to this page (table permissions, maybe role).

    $debugOutput = [
        'request_all'=> $request->all(),
    ];
    return $debugOutput;
    //return view('debug');
});