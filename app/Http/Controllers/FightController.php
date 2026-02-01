<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FightController extends Controller
{
    
    public function getFightHub(Request $request) {
        return view('log.fight.fightHub');
    }


    public function sendFormTwitchOption(Request $request) {

        // todo: debug request.

        return response()->json([
            'message' => 'it\'s work'
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
