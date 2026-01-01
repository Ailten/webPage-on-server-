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

    public function getLoginUrl($redirectUri) {
        $endpoint = self::TWITCH_ID_DOMAIN."oauth2/authorize";

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

        // TODO: verify if can't use a twitch redirect url without SSL certificat and without domaine name.

        $curlOptions = [
            CURLOPT_URL => $params['endpoint'],
            //CURLOPT_CAINFO => env('PATH_TO_CERT'),  // path to certificat SSL (for https).
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2
        ];

        if( $params['type'] == 'POST'){
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = http_build_query($params['url_params']);
        }

        return;  // TODO: return somehting.
    }
}