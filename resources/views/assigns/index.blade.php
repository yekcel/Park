@extends('layouts.app')

@section('title')
    تعین بودجه
@endsection

@section('content')

    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">لیست اعتبارات برنامه ها </div>
                <div class="col-sm-2"><a href="{{url('assigns/add2app')}}" class="btn btn-success btn-xs">اعتبار جدید برنامه</a>
                  {{--<a href="{{url('needs/export')}}" class="btn btn-default btn-xs"><img
                            src="{{asset('img/xlsx-file-format-extension.png')}}">خروجی </a>--}}

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">شماره</th>
                        <th class="text-center">برنامه</th>
                        <th class="text-center">منبع اعتبار</th>
                        <th class="text-center">سال مصرف</th>
                        <th class="text-center">تاریخ تصویب</th>
                        <th class="text-center">مبلغ مصوب</th>
                      {{--  <th class="text-center">مجموع پرداخت های انجام شده</th>
                        <th class="text-center">منبع درآمد</th>
                        <th class="text-center">نوع مصرف</th>--}}
                        <th class="text-center">توضیحات</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>


                    {{-- @foreach($subaction->spent->all() as $spent)--}}
                    @foreach($appassigns as $appassign)
                        <tr class="text-center">

                            <td>{{$appassign->id}}</td>
                            <td>{{$appassign->application->name}}</td>
                            <td>{{$appassign->source->name}}</td>
                            <td>{{$appassign->year}}</td>
                            <td>{{$appassign->date?Verta::instance($appassign->date)->formatJalaliDate():null}}</td>
                            <td>{{$appassign->price}}</td>

                            <td>{{$appassign->comments}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{url('assigns/'.$appassign->id.'/show')}}"
                                       class="btn btn-info btn-xs">اختصاص اعتبار به فعالیت ها</a>
                                    <a href="{{url('assigns'.$appassign->id.'/edit')}}"
                                       class="btn btn-warning btn-xs">ویرایش</a>

                                    <a href="{{url('assigns/'.$appassign->id.'/delete')}}"
                                       class="btn btn-danger btn-xs">حذف</a>


                                </div>
                            </td>

                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
