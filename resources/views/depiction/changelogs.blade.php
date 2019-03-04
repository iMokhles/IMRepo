{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: imokhles--}}
 {{--* Date: 2019-02-27--}}
 {{--* Time: 14:56--}}
 {{--*/--}}
@extends('layouts.framework7_layout')

@section('content')
    <!-- Initial Page, "data-name" contains page name -->
    <div data-name="changelogs" class="page">
        <!-- Scrollable page content -->
        <div class="page-content">
            <!-- Additional "block-strong" class for extra highlighting -->
            <div class="block-title-large margin-top text-align-center">{{$package->Name}}</div>

            <div class="list media-list margin-left margin-right">
                @foreach($changes as $change)
                    @php($changePackage = \App\Models\Package::wherePackageHash($change->package_hash)->first())
                    <div class="block-title-medium margin-top margin-bottom text-align-left">{{$changePackage->Version}}</div>
                    <ul class="margin-bottom mainPackageItemStyle">
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <ul class="mainWhatsNewList">
                                        @foreach($change->changes as $key => $value)
                                            <li> {{$key+1}} - {{$value['change']}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
@endsection