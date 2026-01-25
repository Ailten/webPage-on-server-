<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\FightController;
use App\Http\Controllers\ItemController;
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
    Route::get('/twitch', 'loginTwitch')
    ->name('twitch');

    // route to form login, with twitch whisper.
    Route::get('/twitchWhisper', function() {
        return view('twitchWhisper');
    })->name('twitchWhisper');

    // route submit form login, twitch whisper.
    Route::get('/twitchWhisper/validate', 'loginTwitchWhisper')
    ->name('twitchWhisper.validate');

});

// route to logout.
Route::delete('/logout', [UserController::class, 'logout'])
->name('logout')
->middleware('auth');

Route::prefix('/log')
->name('log.')
->middleware('auth')
->group(function () {

    Route::prefix('/character')
    ->name('character.')
    ->group(function() {

        // see characters of user log.
        Route::get('/listSelf', [CharacterController::class, 'getCharactersUserLog'])
        ->name('listSelf');

        // form to create a character.
        Route::get('/create', function(){
            return view('log.characterCreate');
        })->name('create');
    
        // submit form create character.
        Route::post('/createValidate', [CharacterController::class, 'createCharacterUserLog'])
        ->name('createValidate');

        // delete a character.
        Route::get('/delete-{id}', [CharacterController::class, 'deleteCharacter'])
        ->name('delete')
        ->where([
            'id' => '[0-9]+',
        ]);

        // page menu details of a character (stats, items-equiped, xp).
        Route::get('/details-{id}', [CharacterController::class, 'detailsCharacter'])
        ->name('details')
        ->where([
            'id' => '[0-9]+',
        ]);

    });


    Route::prefix('/item')
    ->name('item.')
    ->group(function() {

        // get page of
        Route::get('/inventory', [ItemController::class, 'getInventoryUserLog'])
        ->name('inventory');

    });


    Route::prefix('/fight')
    ->name('fight.')
    ->group(function() {

        // open page fight.
        Route::get('/hub', [FightController::class, 'getFightHub'])
        ->name('hub');

        // send form twitchOption.
        Route::post('twitchOption', [FightController::class, 'sendFormTwitchOption'])
        ->name('twitchOption');

    });

});

// debug.
Route::get('/debug', function (Request $request) {

    // TODO: add a controller, to verify is loged and if it's an user who has permission to this page (table permissions, maybe role).

    $debugOutput = [
        'request_all'=> $request->all(),
    ];
    return $debugOutput;
    //return view('debug');
});