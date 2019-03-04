<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 07/12/2018
 * Time: 13:28
 */

namespace App\Helpers;


class FBAccountKitHelper
{

    // Initialize variables
    protected static  $app_id = '<facebook_app_id>';
    protected static  $secret = '<account_kit_app_secret>';
    protected static  $version = 'v1.1';

    /**
     * @param $url
     * @return mixed
     */
    private static function doCurl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        return $data;
    }


    /**
     * Get Returned Data
     *
     * @param $code
     * @return mixed
     */
    private static function data($code)
    {

        self::$app_id = config('services.accountkit.appId');
        self::$secret = config('services.accountkit.appSecret');

        // Exchange authorization code for access token
        $token_exchange_url = 'https://graph.accountkit.com/'.self::$version.'/access_token?'.
            'grant_type=authorization_code'.
            '&code='.$code.
            "&access_token=AA|".self::$app_id."|".self::$secret;
        $data = self::doCurl($token_exchange_url);

        if (!isset($data['error'])) {
            $user_id = $data['id'];
            $user_access_token = $data['access_token'];
            $refresh_interval = $data['token_refresh_interval_sec'];

            $appsecret_proof = hash_hmac('sha256', $user_access_token, self::$secret);

            // Get Account Kit information
            $me_endpoint_url = 'https://graph.accountkit.com/'.self::$version.'/me?'.
                'access_token='.$user_access_token. '&appsecret_proof='.$appsecret_proof;
            $data = self::doCurl($me_endpoint_url);

            return $data;
        } else {
            dd($data);
            return false;
        }

    }

    // Todo: catch error from the exception

    /**
     * Get All User Data
     *
     * @param $code
     * @return mixed
     */
    public function accountKitData($code)
    {
        $data = $this->data($code);
        if (is_bool($data)) {
            // failed
            return false;
        } else {
            $phone = isset($data['phone']) ? $data['phone']['number'] : '';

            $output = [
                'phoneNumber' => $phone
            ];

            return $output;
        }

    }
}