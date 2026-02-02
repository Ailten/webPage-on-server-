<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FightController extends Controller
{
    
    public function getFightHub(Request $request) {
        return view('log.fight.fightHub');
    }


    public function sendFormTwitchOption(Request $request) {

        $pparamValidated = $request->validate([
            'cmdJoin' => ['string', 'regex:/^![a-zA-Z_-]+ \{pseudo\}$/']
        ], [
            'cmdJoin.string' => 'cmdJoin doit être une commande (text).',
            'cmdJoin.regex' => 'cmdJoin doit commencer par "!" et finir par "{pseudo}".'
        ]);

        return response()->json([
            'message' => 'it\'s work',

            'params' => $pparamValidated
        ]);

    }
    public function sendFormCharacterOption(Request $request) {

        // todo: debug request.

        return response()->json([
            'message' => 'it\'s work'
        ]);

    }
    public function sendFormMobOption(Request $request) {

        // todo: debug request.

        return response()->json([
            'message' => 'it\'s work'
        ]);

    }

}
