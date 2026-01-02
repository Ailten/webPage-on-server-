<?php

namespace App\Utils\Twitch;

use PhpOption\None;

// doc : https://www.youtube.com/watch?v=n9oO5D-aHCY  11:00
class TwitchAPI {
    const TWITCH_ID_DOMAIN = 'https://id.twitch.tv/';
    const TWITCH_API_DOMAIN = 'https://api.twitch.tv/helix/';

    private $_clientId;
    private $_clientSecret;
    private $_accessToken;
    private $_refreshToken;

    public function __construct($clientId, $clientSecret, $accessToken = '') {
        $this->_clientId = $clientId;
        $this->_clientSecret = $clientSecret;
        $this->_accessToken = $accessToken;
    }

    public static function castUriLocalHost($uri){
        return str_replace(
            env("IP_SERVER"), 
            "localhost:8000", 
            $uri
        );
    }

    public function getLoginUrl($redirectUri) {
        $endpoint = self::TWITCH_ID_DOMAIN."oauth2/authorize";

        if(env("IS_DEV_MODE")){
            $redirectUri = self::castUriLocalHost($redirectUri);
        }

        $_SESSION['twitch_state'] = md5(microtime() . mt_rand());

        $params = [
            'client_id' => $this->_clientId,
            'redirect_uri' => $redirectUri, // uri, not url.
            'response_type' => 'code',
            'scope' => 'user:read:email',
            'state' => $_SESSION['twitch_state']
        ];

        return "$endpoint?".http_build_query($params);
    }

    public function tryAndLoginWithTwitch($code, $redirectUri) {
        $endpoint = self::TWITCH_ID_DOMAIN."oauth2/token";

        if(env("IS_DEV_MODE")){
            $redirectUri = self::castUriLocalHost($redirectUri);
        }

        $apiParams = [
            'endpoint' => $endpoint,
            'type' => 'POST',
            'url_params' => [
                'client_id' => $this->_clientId,
                'client_secret' => $this->_clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri
            ]
        ];

        return $this->makeApiCall($apiParams);
    }

    public function makeApiCall($params) {

        $curlOptions = [  // base (for http localhost).
            CURLOPT_URL => $params['endpoint'],
            CURLOPT_RETURNTRANSFER => true,
        ];

        if(!env("IS_DEV_MODE")){  // for https mode (need verification).
            $curlOptions[CURLOPT_CAINFO] = env('PATH_TO_CERT');  // path to certificat SSL (for https).
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = true;
            $curlOptions[CURLOPT_SSL_VERIFYHOST] = 2;
        }

        if($params['type'] == 'POST'){  // mode post.
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = http_build_query($params['url_params']);
        }

        // FIXME : verify with tuto ytb.
        //$ch = curl_init();
        //curl_setopt_array($ch, $curlOptions);
        //$response = curl_exec($ch);
        //curl_close($ch);

        return;  // TODO: return somehting.
    }
}