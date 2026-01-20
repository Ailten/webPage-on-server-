<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CharacterSpecie;
use App\Models\Stat;
use App\Models\XpNeedPerLevel;
use App\Utils\Admin\AdminCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function getCharactersUserLog() {

        // send characters to the view.
        return view('log.characterListSelf', [
            'characters' => Auth::user()->characters
        ]);

    }

    public function createCharacterUserLog(Request $request) {

        $champsForCharacter = $request->validate([
            'pseudo' => ['required', 'min:3', 'max:16', 'regex:/^[\w-]+$/', 'unique:characters,pseudo'],
            'character_specie_id' => ['required', 'not_in:0', 'numeric', 'exists:character_species,id']
        ],[
            'pseudo.required' => 'champs obligatoire !',
            'pseudo.min' => 'le pseudo doit contenir minimum 3 characters !',
            'pseudo.max' => 'le pseudo doit contenir maximum 16 characters !',
            'pseudo.regex' => 'le pseudo ne peu contenir que les caractère alphanumeric non-axentué ("_" et "-") !',
            'pseudo.unique' => 'ce pseudo est déja pris !',
            'pseudo.*' => 'ce champs pose probleme (erreur inconnue) !',
            'character_specie_id.required' => 'champs obligatoire !',
            'character_specie_id.not_in' => 'champs obligatoire !',
            'character_specie_id.numeric' => 'la class doit etre une valeur numeric !',
            'character_specie_id.exists' => 'la class choisie n\'existe pas !',
            'character_specie_id.*' => 'ce champs pose probleme (erreur inconnue) !',
        ]);

        $champsForCharacter['user_id'] = Auth()->user()->id;
        Character::create($champsForCharacter);

        return redirect()->route('log.character.listSelf');
    }

    public function deleteCharacter(Request $request, $id) {

        $character = Character::find($id);

        // verify if id exist.
        if(!$character){
            return redirect()->back()->with('error', 'Ce Character n\'existe pas !');
        }

        // verify if user log possess the character to delete.
        $isAuthOwner = $character->user_id == Auth()->user()->id;
        if(!$isAuthOwner && !AdminCheck::isAdmin(Auth()->user())){
            return redirect()->back()->with('error', 'Vous n\'etes pas propriétaire de ce Character !');
        }

        // delete.
        $character->delete();

        return redirect()->back();

    }

    public function detailsCharacter(Request $request, $id) {

        $character = Character::with([
            'xpNeedPerLevel',
            'stat',
            'itemRefs' => function($query) {
                $query->orderBy('item_category_id');
            },
        ])
        ->find($id);

        // verify if id exist.
        if(!$character){
            return redirect()->back()->with('error', 'Ce Character n\'existe pas !');
        }

        // verify if user log possess the character to delete.
        $isAuthOwner = $character->user_id == Auth()->user()->id;
        if(!$isAuthOwner && !AdminCheck::isAdmin(Auth()->user())){
            return redirect()->back()->with('error', 'Vous n\'etes pas propriétaire de ce Character !');
        }

        //$xpNeedForLvlUp = XpNeedPerLevel::where('level', '=', $character->level)->first();
        //$xpNeedForLvlUp = (isset($xpNeedForLvlUp)? $xpNeedForLvlUp->xp_need: -1);

        //$itemEquiped = $character->itemEquipeds;

        //$stat = $character->stat;

        // send characters to the view.
        return view('log.characterDetails', [
            'character' => $character,
            //'xpNeedForLvlUp' => $xpNeedForLvlUp,
            //'itemEquiped' => $itemEquiped,
            //'stat' => $stat
        ]);

    }
}
