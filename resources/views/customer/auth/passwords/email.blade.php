{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: imokhles--}}
 {{--* Date: 2019-03-02--}}
 {{--* Time: 02:49--}}
 {{--*/--}}
@extends('layouts.framework7_layout')

@section('content')

    <!-- Initial Page, "data-name" contains page name -->
    <div data-name="password_email" class="page">

        <!-- Fixed/Dynamic Navbar -->
        <div class="navbar">
            <div class="navbar-inner sliding">
                <div class="left">
                </div>
                <div class="title mainNavigationTitleStyle">@lang('imrepo.reset_password')</div>
                <div class="right">
                </div>
            </div>
        </div>
        <!-- Scrollable page content -->
        <div class="page-content">
            <div class="block-footer margin-left margin-right text-align-center">
                <p>@lang('imrepo.reset_instruction')</p>
            </div>

            @if ($errors->count())
                <ul>
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            @endif

            <!-- Login form -->
            <form method="POST" class="form-ajax-submit" action="{{ route('customer.password.email') }}">

                @csrf
                <div class="list no-hairlines-md margin-left margin-right">
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
                </div>

                <div class="list margin-left margin-right ">
                    <button type="submit" class="list-button loginPageButtonStyle">@lang('imrepo.send_password_reset_link')</button>
                </div>
            </form>
        </div>
    </div>
@endsection