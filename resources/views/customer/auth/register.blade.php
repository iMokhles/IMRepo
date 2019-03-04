{{--/**--}}
{{--* Created by PhpStorm.--}}
{{--* User: imokhles--}}
{{--* Date: 2019-03-02--}}
{{--* Time: 02:48--}}
{{--*/--}}
@extends('layouts.framework7_layout')

@section('content')

    <!-- Initial Page, "data-name" contains page name -->
    <div data-name="register" class="page">

        <!-- Fixed/Dynamic Navbar -->
        <div class="navbar">
            <div class="navbar-inner sliding">
                <div class="left">
                </div>
                <div class="title mainNavigationTitleStyle">@lang('imrepo.register')</div>
                <div class="right">
                </div>
            </div>
        </div>
        <!-- Scrollable page content -->
        <div class="page-content">
            <div class="login-screen-title"></div>

            @if ($errors->count())
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif
        <!-- Login form -->
            <form method="POST" class="form-ajax-submit" action="{{ route('customer.register') }}">

                @csrf
                <div class="list no-hairlines-md margin-left margin-right">
                    <ul class="mainPackageItemStyle margin-bottom">
                        <li class="item-content item-input mainPackageItemStyle">
                            <div class="item-media">
                                <i class="f7-icons ios-only">person</i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">@lang('imrepo.name')</div>
                                <div class="item-input-wrap">
                                    <input autocomplete="off" type="text" name="name" placeholder="@lang('imrepo.name_plh')">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="mainPackageItemStyle margin-bottom">
                        <li class="item-content item-input mainPackageItemStyle">
                            <div class="item-media">
                                <i class="f7-icons ios-only">email</i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">@lang('imrepo.email')</div>
                                <div class="item-input-wrap">
                                    <input autocomplete="off" type="email" name="email" placeholder="@lang('imrepo.email_plh')">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="mainPackageItemStyle margin-bottom">
                        <li class="item-content item-input mainPackageItemStyle">
                            <div class="item-media">
                                <i class="f7-icons ios-only">lock</i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">@lang('imrepo.password')</div>
                                <div class="item-input-wrap">
                                    <input autocomplete="off" type="password" name="password" placeholder="@lang('imrepo.password_plh')">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="mainPackageItemStyle">
                        <li class="item-content item-input mainPackageItemStyle">
                            <div class="item-media">
                                <i class="f7-icons ios-only">lock</i>
                            </div>
                            <div class="item-inner">
                                <div class="item-title item-label">@lang('imrepo.passwordConfirmation')</div>
                                <div class="item-input-wrap">
                                    <input autocomplete="off" type="password" name="password_confirmation" placeholder="@lang('imrepo.passwordConfirmation_plh')">
                                    <span class="input-clear-button"></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="list margin-left margin-right ">
                    <button type="submit" class="list-button loginPageButtonStyle">@lang('imrepo.sign_up')</button>
                </div>

                <div class="list margin-left margin-right ">
                    <p class="row justify-content-center" style="font-size: 18px; font-weight: bold;">
                        @lang('imrepo.register_with')
                    </p>
                    <p class="row">
                        <a class="col link list-button loginPageFBButtonStyle">@lang('imrepo.facebook')</a>
                        <a class="col link list-button loginPageTWButtonStyle">@lang('imrepo.twitter')</a>
                        <a class="col link list-button loginPageGPButtonStyle">@lang('imrepo.google')</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection