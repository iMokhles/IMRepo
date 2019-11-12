{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: imokhles--}}
 {{--* Date: 2019-02-26--}}
 {{--* Time: 13:39--}}
 {{--*/--}}
@extends('layouts.framework7_layout')

@php
    $depiction = \App\Models\Depiction::wherePackageId($package->id)->first();
    $screenshots = $depiction->getMedia('media');
    $changeLog = \App\Models\ChangeLog::wherePackageHash($package->package_hash)->orderBy('package_version', 'desc')->get();

@endphp
@section('content')

    <!-- Initial Page, "data-name" contains page name -->
    <div data-name="depiction" class="page">
        <!-- Scrollable page content -->
        <div class="page-content">
            <!-- Additional "block-strong" class for extra highlighting -->
            <div class="display-flex justify-content-center align-items-center">
                <img class="margin-top" src="{{asset('images/Sections').'/'.$package->Section}}.png" width="100"/>
            </div>
            <div class="block-title-large margin-top text-align-center">{{$package->Name}}</div>
            <div class="list media-list margin-left margin-right">

                <div class="block-title-medium margin-top margin-bottom text-align-left">@lang('imrepo.description')</div>
                <ul class="margin-bottom mainPackageItemStyle">
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                {!! $depiction->long_description !!}
                            </div>
                        </div>
                    </li>
                </ul>

                <div class="block-title-medium margin-top margin-bottom text-align-left">@lang('imrepo.whats_new')</div>
                <ul class="margin-bottom mainPackageItemStyle">
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <ul class="mainWhatsNewList">
                                    @php($smallChanges = json_decode($changeLog[0]->changes, true))
                                    @foreach($smallChanges as $key => $value)
                                        <li> {{$key+1}} - {{$value['change']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="mainWhatsNewMoreSeparator">
                        </div>
                        <a href="{{route('package.depiction.changes', ['id' => $package->package_hash])}}" class="external button col color-blue mainWhatsNewPreviuosButton">Previous Changes</a>

                    </li>
                </ul>
                <div class="block-title-medium margin-top margin-bottom text-align-left">@lang('imrepo.screenshots')</div>
                <ul class="margin-bottom mainScreenshotsItemStyle">
                    <li>
                        <div class="item-content justify-content-center">
                            <div data-pagination='{"el": ".swiper-pagination"}' data-space-between="20" data-slides-per-view="2" class="margin-top margin-right swiper-container swiper-init demo-swiper">
                                <div class="swiper-wrapper">
                                    @foreach($screenshots as $screenshot)
                                        <div class="swiper-slide">
                                            <a class="external" href="{{url($screenshot->getUrl('thumb'))}}">
                                                <img id="{{$screenshot->id}}" style="border-radius: 0px;" src="{{url($screenshot->getUrl('thumb'))}}" alt="{{$screenshot->name}}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="block-title-medium margin-top margin-bottom text-align-left">@lang('imrepo.author')</div>
                <ul class="margin-bottom mainPackageItemStyle">
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <div class="item-title-row">
                                    <div class="item-title">{{$package->Author}}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="block-title-medium margin-top margin-bottom text-align-left">@lang('imrepo.information')</div>
                <div class="list margin-top">
                    <ul class="mainPackageItemStyle">
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.uploaded')</div>
                                        <div class="item-after">{{$first_package->created_at->format('d M Y H:i:s')}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.updated')</div>
                                        <div class="item-after">{{$package->updated_at->format('d M Y H:i:s')}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.version')</div>
                                        <div class="item-after">{{$package->Version}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.supported_versions')</div>
                                        <div class="item-after">{{$depiction->mini_ios}} - {{$depiction->max_ios}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.paid')</div>
                                        <div class="item-after">{{($package->is_paid) ? trans('imrepo.yes') : trans('imrepo.no')}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.section')</div>
                                        <div class="item-after">{{$package->Section}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.depends')</div>
                                    </div>
                                    <div class="item-text">{{$package->Depends}}</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.conflicts')</div>
                                    </div>
                                    <div class="item-text">{{$package->Conflicts}}</div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">@lang('imrepo.size')</div>
                                        <div class="item-after">{{\App\Helpers\IMPackageHelper::formatSizeUnits($package->Size)}}</div>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection
