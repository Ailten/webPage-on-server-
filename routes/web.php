<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\FightController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Models\Character;
use App\Models\ItemRef;
use App\Models\User;
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
        })
        ->name('create')
        ->middleware('auth.notbanned');
    
        // submit form create character.
        Route::post('/createValidate', [CharacterController::class, 'createCharacterUserLog'])
        ->name('createValidate')
        ->middleware('auth.notbanned');

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
    ->middleware('auth.notbanned')
    ->group(function() {

        // open page fight.
        Route::get('/hub', [FightController::class, 'getFightHub'])
        ->name('hub');

        // send form twitchOption.
        Route::post('twitchOption', [FightController::class, 'sendFormTwitchOption'])
        ->name('twitchOption');
        // send form characterOption.
        Route::post('characterOption', [FightController::class, 'sendFormCharacterOption'])
        ->name('characterOption');
        // send form mobOption.
        Route::post('mobOption', [FightController::class, 'sendFormMobOption'])
        ->name('mobOption');

    });

});

// debug.
Route::prefix('/debug')
->name('debug.')
->group(function () {

    // debug all users.
    Route::get('/users', function (Request $request) {
        return User::all()->paginate(10);
    })->name('users');
    // debug one user (by id).
    Route::get('/user-{id}', function (Request $request, $id) {
        return User::find($id);
    })->where(['id' => '[0-9]+'])
    ->name('user');

    // debug all characters.
    Route::get('/characters', function (Request $request) {
        return Character::all()->paginate(10);
    })->name('characters');
    // debug one character (by id).
    Route::get('/character-{id}', function (Request $request, $id) {
        return Character::find($id);
    })->where(['id' => '[0-9]+'])
    ->name('character');
    // debug all characters of an user (by idUser).
    Route::get('/characterFromUser-{idUser}', function (Request $request, $idUser) {
        return User::find($idUser)->characters();
    })->where(['idUser' => '[0-9]+'])
    ->name('characterFromUser');

    // debug items.
    Route::get('/items', function (Request $request) {
        return ItemRef::all()->paginate(10);
    })->name('items');
    // debug one item (by id).
    Route::get('/item-{id}', function (Request $request, $id) {
        return ItemRef::find($id);
    })->where(['id' => '[0-9]+'])
    ->name('item');
    // debug inventory (by idUser).
    Route::get('/inventory-{idUser}', function (Request $request, $idUser) {
        return User::find($idUser)
            ->inventories()
            ->leftJoin('equipeds', 'equipeds.inventory_id', '=', 'inventories.id')
            ->leftJoin('characters', 'characters.id', '=', 'equipeds.character_id')
            ->join('item_refs', 'item_refs.id', '=', 'inventories.item_ref_id')
            ->join('item_categories', 'item_categories.id', '=', 'item_refs.item_categorie_id')
            ->join('item_rarities', 'item_rarities.id', '=', 'item_refs.item_rarity_id')
            
            ->paginate(10, [  // pagination.
                'inventories.id as id',
                'inventories.quantity as quantity',
                DB::raw('COUNT(characters.id) as equiped_quantity'),
                'item_refs.name as name',
                'item_refs.price as price',
                'item_refs.level as level',
                'item_categories.name as item_categorie',
                'item_rarities.name as item_rarity',

            ]);
    })->where(['idUser' => '[0-9]+'])
    ->name('inventory');

});