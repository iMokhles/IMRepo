<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 15/11/2018
 * Time: 20:19
 */

namespace App\Helpers;


use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\One\TwitterProvider;
use League\OAuth1\Client\Server\Twitter as TwitterServer;

class SocialiteHelper
{

    /**
     * @param $social
     * @param $type
     * @return TwitterProvider|\Laravel\Socialite\One\User
     */
    static public function getSocialiteUser($social, $type) {

        return self::getSocialiteInstance($social, $type)->user();
    }
    /**
     * @param $social
     * @param $type
     * @return TwitterProvider|mixed
     */
    static public function getSocialiteInstance($social, $type) {

        $redirectUrl = route("customer.social.$type.handler", ['social' => $social]);
        $serviceConfig = config('services.' . $social);
        $serviceConfig['redirect'] = $redirectUrl;

        if (strtolower($social) === 'twitter') {
            return new TwitterProvider(
                app('request'), new TwitterServer(self::formatConfig($serviceConfig))
            );
        } else if (strtolower($social) === 'facebook') {
            return Socialite::buildProvider(\Laravel\Socialite\Two\FacebookProvider::class, $serviceConfig);

        } else {

            return Socialite::with($social);
        }
    }

    /**
     * Format the server configuration.
     *
     * @param  array  $config
     * @return array
     */
    static protected function formatConfig(array $config)
    {
        return array_merge([
            'identifier' => $config['client_id'],
            'secret' => $config['client_secret'],
            'callback_uri' => self::formatRedirectUrl($config),
        ], $config);
    }
    /**
     * Format the callback URL, resolving a relative URI if needed.
     *
     * @param  array  $config
     * @return string
     */
    static protected function formatRedirectUrl(array $config)
    {
        $redirect = value($config['redirect']);
        return Str::startsWith($redirect, '/')
            ? app('url')->to($redirect)
            : $redirect;
    }
}