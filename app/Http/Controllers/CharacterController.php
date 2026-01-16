<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Stat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function getCharactersUserLog() {

        // get character list from user log.
        $characters = Character::where('user_id', '=', Auth::user()->id)->get();

        // send characters to the view.
        return view('log.charactersSelection', [
            'characters' => $characters
        ]);

    }

    public function createCharacterUserLog(Request $request) {

        $champsForCharacter = $request->validate([
            'pseudo' => ['required', 'min:3', 'max:16', 'regex:/^[\w-]+$/', 'unique:characters,pseudo'],
            'class' => ['required', 'numeric', 'exists:character_species,id']
        ],[
            'pseudo.required' => 'champs obligatoire !',
            'pseudo.min' => 'le pseudo doit contenir minimum 3 characters !',
            'pseudo.max' => 'le pseudo doit contenir maximum 16 characters !',
            'pseudo.regex' => 'le pseudo ne peu contenir que les caractère alphanumeric non-axentué ("_" et "-") !',
            'pseudo.unique' => 'ce pseudo est déja pris !',
            'pseudo.*' => 'ce champs pose probleme (erreur inconnue) !',
            'class.required' => 'champs obligatoire !',
            'class.numeric' => 'la class doit etre une valeur numeric !',
            'class.exists' => 'la class choisie n\'existe pas !',
            'class.*' => 'ce champs pose probleme (erreur inconnue) !',
        ]);

        $champsForCharacter['user_id'] = Auth()->user()->id;
        $statCharacter = Stat::create([]);
        $champsForCharacter['stat'] = $statCharacter->id;
        Character::create($champsForCharacter);

        // todo: try if create character work.
        // make html/css of div "select character".

        return view('index');
    }
}
