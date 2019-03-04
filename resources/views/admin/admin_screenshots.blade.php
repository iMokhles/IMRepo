{{--/**--}}
 {{--* Created by PhpStorm.--}}
 {{--* User: imokhles--}}
 {{--* Date: 2019-02-26--}}
 {{--* Time: 23:26--}}
 {{--*/--}}
@php
    $depiction = \App\Models\Depiction::find($entry->id)->first();
    $screenshots = $depiction->getMedia('media');
@endphp
<div @include('crud::inc.field_wrapper_attributes') >
    <div class="box-header with-border">
        <h3 class="box-title">{!! $field['label'] !!}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <ul class="users-list clearfix">
            @foreach($screenshots as $screenshot)
                <li>
                    <img id="{{$screenshot->id}}" style="border-radius: 0px;" src="{{url($screenshot->getUrl('thumb'))}}" alt="{{$screenshot->name}}">
                    <a class="btn btn-block btn-danger"
                       href="{{route('delete.screenshot', ['id' => $screenshot->id])}}"
                       onclick="return confirm('Are you sure?')">
                        <i class="fa fa-times-circle" style="font-size: 20px"></i>
                    </a>
                </li>
            @endforeach
        </ul>
        <!-- /.users-list -->
    </div>
    <!-- /.box-body -->
</div>