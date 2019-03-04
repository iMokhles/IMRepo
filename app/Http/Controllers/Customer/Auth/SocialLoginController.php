<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Helpers\SocialiteHelper;
use App\Http\Controllers\Customer\Controller;
use App\Models\LinkedSocial;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;


class SocialLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Social Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles social authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/customer/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer', ['except' => ['showLogin', 'callbackLogin']]);
    }


    /**
     * Redirect to the provider login page.
     *
     * @param Request $request
     * @param $social
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showLogin(Request $request, $social)
    {

        $type = $request['type'];
        $socialite = SocialiteHelper::getSocialiteInstance($social, $type);
        return $socialite->redirect();

    }

    /**
     * Handle provider callback.
     *
     * @param Request $request
     * @param $social
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callbackLogin(Request $request, $social) {

        $socialUser = SocialiteHelper::getSocialiteUser($social, 'login');
        $linkedSocial = LinkedSocial::whereProviderId($socialUser->getId())->whereProvider($social)->first();
        if ($linkedSocial == null) {
            return redirect(route('customer.login'))
                ->withErrors([
                    'info' => trans('imrepo.social_not_associated_to_account',
                        ['social' => $social])
                ]);
        }
        $loggedIn = \auth('customer')->loginUsingId($linkedSocial->model_id);
        if ($loggedIn) {
            return redirect()->intended($this->redirectPath());
        } else {
            return redirect(route('customer.login'))
                ->withErrors([
                    'info' => trans('imrepo.failed_to_login')
                ]);
        }
    }

    // Todo: merge login and connect to the same functions
    /**
     * Redirect to the provider login page.
     *
     * @param Request $request
     * @param $social
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showConnect(Request $request, $social)
    {

        $type = $request['type'];
        $socialite = SocialiteHelper::getSocialiteInstance($social, $type);
        return $socialite->redirect();

    }

    /**
     * Handle provider callback.
     *
     * @param Request $request
     * @param $social
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callbackConnect(Request $request, $social) {

        $socialUser = SocialiteHelper::getSocialiteUser($social, 'connect');
        $linkedSocial = LinkedSocial::whereProviderId($socialUser->getId())->whereProvider($social)->first();
        if ($linkedSocial != null) {

            Alert::error(trans('imrepo.social_already_associated_to_account',
                ['social' => $social]))->flash();

            return redirect()->intended($this->redirectPath());
        }

        // okey there are no account associated ( let's associate it to the current user )
        $currentUser = $this->guard()->user();
        $userObject = \App\Models\Customer::find($currentUser->id);
        $userObject->setLinkedSocial([
            'provider_id' => !empty($socialUser->getId()) ? $socialUser->getId() : null,
            'provider' => $social,
            'token' => !empty($socialUser->token) ? $socialUser->token : null,
            'refresh_token' => !empty($socialUser->refreshToken) ? $socialUser->refreshToken : null,
            'token_secret' => !empty($socialUser->tokenSecret) ? $socialUser->tokenSecret : null,
            'expires_in' => !empty($socialUser->expiresIn) ? $socialUser->expiresIn : null,
            'nickname' => !empty($socialUser->getNickname()) ? $socialUser->getNickname() : null,
            'name' => !empty($socialUser->getName()) ? $socialUser->getName() : null,
            'email' => !empty($socialUser->getEmail()) ? $socialUser->getEmail() : null,
            'avatar' => !empty($socialUser->getAvatar()) ? $socialUser->getAvatar() : null,

        ]);

        Alert::success(trans('imrepo.social_associated_successfully_to_account',
            ['social' => $social]))->flash();

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }
}
