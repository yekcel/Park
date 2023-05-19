@extends('layouts.app')

@section('title')
    لیست فعالیت ها
@endsection

@section('content')

    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">لیست برنامه ها ها</div>
                {{--<div class="col-sm-2"><a href="{{url('needs/add')}}" class="btn btn-success btn-xs">درخواست جدید</a>
                  <a href="{{url('needs/export')}}" class="btn btn-default btn-xs"><img
                            src="{{asset('img/xlsx-file-format-extension.png')}}">خروجی </a>

                </div>--}}
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($application->actions->all() as $application )

                    <div class="col-sm-3" style="background-color:lavender;">
                        <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive"
                             style="width:100%" alt="Image">
                        <td><a href="{{url('/applications/'.$application->id)}}"> {{$application->name}}</a></td>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection