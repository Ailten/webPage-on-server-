<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\Twitch\TwitchAPI;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginTwitch(Request $request) {

        $code = $request->input('code');

        // if don't have parameter "code" in redirection.
        if(!isset($code)){
            // send a message and redirect to 'index'.
            return route('index');
        }

        // twitch interact API to get token.
        $twitchAPI = new TwitchAPI(env('TWITCH_CLIENT_ID'), env('TWITCH_CLIENT_SECRET'));
        $twitchLogin = $twitchAPI->tryLoginWithTwitch($request->input('code'), env('TWITCH_REDIRECT_URL'));
        
        // error during login.
        if(!$twitchLogin['is_success']){
            // TODO : allow to print the 'message' at the page index (re-watch laravel tuto for it).
            return route('index');
        }

        $userTwitch = $twitchLogin['api_data']['data'][0];

        // verify if this Viewer have already an acount User in DB.
        $userLog = User::where('twitch_id', '=', $userTwitch['id']);
        if(!isset($userLog)){  // if is not already in DB, add it.
            $userLog = new User();
            $userLog->twitch_id = $userTwitch['id'];
            $userLog->twitch_email = $userTwitch['email'];
        }

        // update / create (with refresh token).
        $userLog->twitch_access_token = $twitchLogin['access_Token'];  // refresh token.
        $userLog->twitch_access_token = $twitchLogin['refresh_Token'];
        $userLog->twitch_pseudo = $userTwitch['display_name'];  // update pseudo just in case it was rename on twitch.
        $userLog->save();

        // TODO: place userLog on session (or alternative in Laravel).

        return route('index');
    }
}
