<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Twitch\TwitchAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
