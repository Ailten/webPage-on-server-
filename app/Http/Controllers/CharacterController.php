<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function getCharactersUserLog() {

        // get character list from user log.
        $characters = Character::where('user_id', '=', Auth::user()->id)->get();

        // TODO : send characters to the view.
        return view('log.charactersSelection', [
            'characters' => $characters
        ]);

    }
}
