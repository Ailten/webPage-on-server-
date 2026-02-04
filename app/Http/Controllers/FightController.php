<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FightController extends Controller
{
    
    public function getFightHub(Request $request) {
        return view('log.fight.fightHub');
    }


    public function sendFormTwitchOption(Request $request) {

        // get validator obj from input request.
        $validator = Validator::make($request->only(
        [
            'cmdJoin', 
        ]) ,[
            'cmdJoin' => ['string', 'regex:/^![a-zA-Z_-]+ \{pseudo\}$/'],
        ], [
            'cmdJoin.string' => 'cmdJoin doit être une commande (text).',
            'cmdJoin.regex' => 'cmdJoin doit commencer par "!" et finir par "{pseudo}".',
        ]);

        // do update.
        if(!$validator->fails()){
            $dataFromRequest = $validator->validated();

            // todo : update twitchForm.

            // return succes.
            return response()->json([
                'isSucces' => true,
                'values' => $dataFromRequest,
            ]);
        }

        // return error.
        return response()->json([
            'isSucces' => false,
            'errors' => $validator->errors(),
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
