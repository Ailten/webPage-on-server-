<?php

namespace App\Utils\Twitch;

use UrlManager;

// doc : https://www.youtube.com/watch?v=n9oO5D-aHCY
// TODO : add url https in Twitch platform dev.

class TwitchAPI {
    const TWITCH_ID_DOMAIN = 'https://id.twitch.tv/';
    const TWITCH_API_DOMAIN = 'https://api.twitch.tv/helix/';

    private $_clientId;
    private $_clientSecret;
    private $_accessToken;
    private $_refreshToken;

    public function __construct($clientId, $clientSecret, $accessToken = '', $refreshToken = '') {
        $this->_clientId = $clientId;
        $this->_clientSecret = $clientSecret;
        $this->_accessToken = $accessToken;
        $this->_refreshToken = $refreshToken;
    }

    // get an url for button "login with twitch".
    public function getLoginUrl($redirectUri) {
        $endpoint = self::TWITCH_ID_DOMAIN."oauth2/authorize";

        if(env("IS_DEV_MODE")){
            $redirectUri = UrlManager::castLocalHost($redirectUri);
        }

        $_SESSION['twitch_state'] = md5(microtime() . mt_rand());

        $params = [
            'client_id' => $this->_clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'user:read:email',
            'state' => $_SESSION['twitch_state']
        ];

        return "$endpoint?".http_build_query($params);
    }

    // try to login with twithc (call back from button "login with twitch").
    public function tryAndLoginWithTwitch($code, $redirectUri) {
        $endpoint = self::TWITCH_ID_DOMAIN."oauth2/token";

        if(env("IS_DEV_MODE")){
            $redirectUri = UrlManager::castLocalHost($redirectUri);
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

        $accessToken = $this->makeApiCall($apiParams);
        $output = [
            'is_success' => $accessToken['is_success'],
            'message' => $accessToken['message']
        ];

        // if call login is success.
        if($output['is_success']){
            $this->_accessToken = $accessToken['api_data']->access_token;  // stock token of user log.
            $this->_refreshToken = $accessToken['api_data']->refresh_token;
            $output['access_Token'] = $accessToken['api_data']->access_token;
            $output['refresh_Token'] = $accessToken['api_data']->refresh_token;
            //$accessToken['api_data']->expires_in  // int time (secondes ? 13k +-, 13secondes or 3-4 hours). time validity of token.

            // get obj user log.
            $userInfo = $this->getUserInfo();
            $output['is_success'] = $userInfo['is_success'];
            $output['message'] = $userInfo['message'];

            // handle error from obj User not get properly.
            if($output['is_success'] && !isset($userInfo['api_data']->data[0])){
                $output['is_success'] = false;
                $output['message'] = 'success to login-in to API Twitch, but no acount found';
            }

            // add obj user to the return.
            if($output['is_success']){
                $output['user'] = $userInfo['api_data']->data[0];
            }
        }

        return $output;
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

        if(isset($params['authorization'])){
            $curlOptions[CURLOPT_HEADER] = true;
            $curlOptions[CURLOPT_HTTPHEADER] = $params['authorization'];
        }

        if($params['type'] == 'POST'){  // mode post.
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = http_build_query($params['url_params']);
        }elseif($params['type'] == 'GET'){
            $curlOptions[CURLOPT_URL] .= '?'.http_build_query($params['url_params']);
        }

        // call curl.
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        $apiResponse = curl_exec($ch);

        if(isset($params['authorization'])){
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $apiResponseBody = substr($apiResponse, $headerSize);
            $apiResponse = json_decode($apiResponseBody, true);
        }else{
            $apiResponse = json_decode($apiResponse);
        }

        curl_close($ch);

        return [
            'is_success' => isset($apiResponse->status) ? false: true,
            'message' => isset($apiResponse->message) ? $apiResponse->message: '',
            'api_data' => $apiResponse,
            'endpoint' => $curlOptions[CURLOPT_URL],
            'url_params' => $params['url_params']
        ];
    }

    public function getUserInfo() {
        $endpoint = self::TWITCH_API_DOMAIN.'users';

        $apiParams = [
            'endpoint' => $endpoint,
            'type' => 'GET',
            'authorization' => $this->getAuthorizationHeaders(),
            'url_params' => []
        ];

        return $this->makeApiCall($apiParams);
    }

    public function getAuthorizationHeaders() {
        return [
            'Client-ID: '.$this->_clientId,
            'Authorization: Bearer '.$this->_accessToken 
        ];
    }

    /*
    // get user from DB matching to the user return from login.
    private function _logUserInWithTwitch($apiUserInfo) {
        $_SESSION['twitch_user_info'] = $apiUserInfo;
        $_SESSION['twitch_user_info']['access_token'] = $this->_accessToken;
        $_SESSION['twitch_user_info']['refresh_token'] = $this->_refreshToken;
        $_SESSION['eci_login_required_to_connect_twitch'] = false;

        // check to find user in DB.
        $userInfoWithId = getRowWithValue('users', 'twitch_user_id', $apiUserInfo['id']);

        // check to find user with email.
        $userInfoWithEmail = getRowWithValue('users', 'email', $apiUserInfo['email']);

        // ... continue tuto, not used (19:19).

    }
    */
}