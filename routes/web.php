<?php

use App\Utils\Twitch\TwitchAPI;
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

Route::get('/', function () {
    return view('index');
})->name('index');

Route::prefix('/login')->name('login.')->group(function () {

    // route to login-redirect, with twitch OAuth.
    Route::get('/twitch', function(Request $request) {

        // TODO: continue to create the ORM (and create the DB MCD with flowgoritme).

        // TODO: place all this bloc in a Controller.
        $twitchAPI = new TwitchAPI(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
        $twitchLogin = $twitchAPI->tryLoginWithTwitch($request->input('code'), env('TWITCH_REDIRECT_URL'));
        
        // error during login.
        if(!$twitchLogin['is_success']){
            // TODO : allow to print the 'message' at the page index (re-watch laravel tuto for it).
            return route('index');
        }

        // TODO : from DB an acount who has matching twitch_id, or create a new one.
        // update user with access_token, refresh_token
        // stock user in session (alternative laravel).

        //$userLog = new User();

        // need a controler to cast param from api twitch, into a class fillable "user".

        return route('index');
    })->name('twitch');

});

Route::get('/debug', function (Request $request) {

    // TODO: add a controller, to verify is loged and if it's an user who has permission to this page (table permissions, maybe role).

    $debugOutput = [
        'request_all'=> $request->all(),
    ];
    return $debugOutput;
    //return view('debug');
});