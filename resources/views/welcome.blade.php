@extends('layouts.framework7_layout')

@section('content')
    <!-- Initial Page, "data-name" contains page name -->
    <div data-name="home" class="page">
        <!-- Fixed/Dynamic Navbar -->
        <div class="navbar">
            <div class="navbar-inner sliding">
                <div class="left">
                </div>
                <div class="title"></div>
                <div class="right">
                    @if(!auth('customer')->check())
                        <a href="{{route('customer.login')}}" class="link external justify-content-center authLinkStyle">@lang('backpack::base.login')</a>
                     @else
                        <a href="{{route('customer.dashboard')}}" class="link external justify-content-center authLinkStyle">@lang('backpack::base.dashboard')</a>
                    @endif

                </div>
            </div>
        </div>
        <!-- Scrollable page content -->
        <div class="page-content">
            <!-- Additional "block-strong" class for extra highlighting -->
            <div class="block-title-large margin-top text-align-center">{{config('app.name')}}</div>

            <!-- Searchbar with auto init -->
            <form class="searchbar margin-left margin-right margin-top">
                <div class="searchbar-inner">
                    <div class="searchbar-input-wrap">
                        <input type="search" placeholder="Search">
                        <i class="searchbar-icon"></i>
                        <span class="input-clear-button"></span>
                    </div>
                    <span class="searchbar-disable-button">Cancel</span>
                </div>
            </form>


            <div class="list media-list margin-left margin-right">
                @foreach($packages as $package)
                    <ul class="margin-bottom mainPackageItemStyle">
                        <li>
                            <a href="/depiction/{{$package->package_hash}}" class="item-link item-content external">
                                <div class="item-media">
                                    <img src="{{asset('images/Sections').'/'.$package->Section}}.png" width="80"/>
                                </div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">{{$package->Name}}</div>
                                        <div class="item-after">{{$package->Section}}</div>
                                    </div>
                                    <div class="item-subtitle">{{$package->Version}}</div>
                                    <div class="item-text">{{$package->Description}}
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                @endforeach

            </div>
        </div>
    </div>
@endsection
