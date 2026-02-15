<?php

namespace App\Http\Controllers;

use App\Models\BotTwitch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            // get botTwitch row (or create).
            $botTwitchModel = BotTwitch::where('user_id', '=', Auth()->user()->id)->first();
            if(is_null($botTwitchModel)){
                $botTwitchModel = new BotTwitch();
                $botTwitchModel->user_id = Auth()->user()->id;
            }

            // update botTwitch row (and save).
            $botTwitchModel->cmdJoin = $dataFromRequest['cmdJoin'];
            $botTwitchModel->save();


            // todo : update twitchForm.
            // todo : connect bot twitch to channel auth. (disconnect before if already connected).
            // see DB structur for the "botTwitchParameter".
            // see how to dev botTwitch on a php web-backend.

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
