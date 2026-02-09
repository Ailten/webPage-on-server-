<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Twitch\TwitchAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function loginTwitch(Request $request) {

        $code = $request->input('code');

        // if don't have parameter "code" in redirection.
        if(!isset($code)){
            return redirect()->route('index')->with('error', 'le parametre code est absent !');
        }

        // twitch interact API to get token.
        $twitchAPI = new TwitchAPI(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
        $twitchLogin = $twitchAPI->tryLoginWithTwitch($request->input('code'), env('TWITCH_REDIRECT_URL'));
        
        // error during login.
        if(!$twitchLogin['is_success']){
            return redirect()->route('index')->with('error', $twitchLogin['message']);
        }

        $userTwitch = $twitchLogin['user'];

        // verify if this Viewer have already an acount User in DB.
        $userLog = User::where('twitch_id', '=', $userTwitch['id'])->first();
        if(!isset($userLog)){  // if is not already in DB, add it.
            $userLog = new User();
            $userLog->twitch_id = $userTwitch['id'];
            $userLog->twitch_email = $userTwitch['email'];
        }

        // update / create (with refresh token).
        $userLog->twitch_access_token = $twitchLogin['access_Token'];  // refresh token.
        $userLog->twitch_refresh_token = $twitchLogin['refresh_Token'];
        $userLog->twitch_pseudo = $userTwitch['display_name'];  // update pseudo just in case it was rename on twitch.
        $userLog->twitch_profile_picture = $userTwitch['profile_image_url'];  // update pfp.
        $userLog->save();

        // place userLog on session (log user).
        Auth::login($userLog);
        $request->session()->regenerate();

        return redirect()->route('index');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('index');
    }

    public function loginTwitchWhisper(Request $request) {

        $isHasSecretCode = session()->has('twitch_secret_code_whisper');

        // if do not contend a secret-code -> generate and return to page "ask secret-code to user".
        if(!$isHasSecretCode){

            // get only parameters who match constraints.
            $validated = $request->validate([
                'pseudo' => 'required|regex:/^[a-zA-Z0-9_-]{1,}$/',
            ],[
                'pseudo' => 'pseudo invalide',
            ]);

            $secretCode = TwitchAPI::generateSecretCode();
            $pseudoTwitch = $validated['pseudo'];

            $twitchApi = new TwitchAPI(
                env('BOT_TWITCH_CLIENT_ID'), 
                env('BOT_TWITCH_CLIENT_SECRET'), 
                env('BOT_TWITCH_ACCESS_TOKEN')
            );
            $userTwitch = $twitchApi->getUser($pseudoTwitch);
            if(!$userTwitch['is_success']){
                session()->flush();
                return redirect()->back()->with('error', $userTwitch['message']);
            }
            $userTwitch = $userTwitch['user'];

            $websiteName = env('WEBSITE_NAME');
            $whisperResult = $twitchApi->whisper(
                "Voici votre code d'identification pour $websiteName : [$secretCode]. Si vous n'avez fait aucune demande d'identification : igniorer simplement ce message.",
                $userTwitch['id']
            );
            dd($whisperResult);
            if(!$whisperResult['is_success']){
                session()->flush();
                return redirect()->back()->with('error', $whisperResult['message']);
            }

            session()->put('twitch_pseudo_whisper', $pseudoTwitch);
            session()->put('twitch_secret_code_whisper', $secretCode);

            return redirect()->back()->withInput();

        }
        // else if contend a secret-code and a secret-code-sugest -> verify comparaison
        else{

            $tryMaxAllow = 3;
            $tryCount = session('twitch_secret_code_whisper_try', 0);
            $tryCount++;
            $tryUntilLock = $tryMaxAllow - $tryCount;

            $validator = Validator::make(
                $request->only(['code']),
            [
                'code' => 'required|regex:/^'.session('twitch_secret_code_whisper').'$/',
            ],[
                'code' => "code invalide (essai restant : $tryUntilLock/$tryMaxAllow)"
            ]);

            if($validator->fails()){

                // code not valide, but can try again.
                if($tryUntilLock > 0){
                    session()->increment('twitch_secret_code_whisper_try');
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // code not valide, and no more try allow.
                session()->flush();
                return redirect()->back()->with('error', 'code invalide, essai épuisé !');

            }

            // code valide.
            if(!session()->has('twitch_pseudo_whisper')){
                session()->flush();
                return redirect()->back()->with('error', 'pseudo twitch introuvable !');
            }
            $pseudoTwitch = session('twitch_pseudo_whisper');

            $twitchApi = new TwitchAPI(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
            $userTwitch = $twitchApi->getUser($pseudoTwitch);
            if(!$userTwitch['is_success']){
                session()->flush();
                return redirect()->back()->with('error', $userTwitch['message']);
            }
            dd($userTwitch);
            $userTwitch = $userTwitch['user'];

            // verify if this Viewer have already an acount User in DB.
            $userLog = User::where('twitch_id', '=', $userTwitch['id'])->first();
            if(!isset($userLog)){  // if is not already in DB, add it.
                $userLog = new User();
                $userLog->twitch_id = $userTwitch['id'];
                $userLog->twitch_email = $userTwitch['email'];
            }
    
            // update / create (with refresh token).
            $userLog->twitch_access_token = 'null';  // refresh token.
            $userLog->twitch_refresh_token = 'null';
            $userLog->twitch_pseudo = $userTwitch['display_name'];  // update pseudo just in case it was rename on twitch.
            $userLog->save();
    
            // place userLog on session (log user).
            Auth::login($userLog);
            $request->session()->regenerate();

            return redirect()->route('index');

        }
        
    }

    
}
