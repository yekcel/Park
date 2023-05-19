@extends('layouts.app')

@section('title')
   برناهه {{$application->name}}
@endsection

@section('content')

    <div class="card  " style="border-color: #0871bd; margin: 2px">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-9 "><h5 class="text-primary"> ثبت هزینه ها <span style="color: #2fcc71" ><b> > </b></span> {{ $application->name }}</h5></div>
                <div class="col-sm-3"><a href="{{url('applications')}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
                    <a href="{{url('select_year')}}" class="btn btn-dark btn-xs"><i class="fa fa-calendar-check-o icon" style="padding-left: 2px;"></i>  بازگشت به انتخاب سال مالی</a>
                  {{--<a href="{{url('needs/export')}}" class="btn btn-default btn-xs"><img
                            src="{{asset('img/xlsx-file-format-extension.png')}}">خروجی </a>--}}

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
            <div class="card " style="border-color: #0871bd; margin: 2px">
                <div class="card-header  text-white " style="background: linear-gradient(90deg,#183468,#150f50); "><i class="fa fa-info-circle icon" style="padding-left: 2px;"></i>  اعتبارات سال<span class="bg-dark text-success"style=" margin: 5px;  padding-right:5px;Border-radius:5px;">{{$year}}</span> </div>
                <div class="card-body">
                    <div class="row bg-white ">


                        <table class="table table-bordered table-striped table-hover ">
                            <thead class="bg-primary text-white">
                            <th class="text-center" >عنوان منبع اعتبار</th>
                            <th class="text-center" >مبلغ مصوب</th>
                            <th class="text-center" >مبلغ اعتبار</th>
                            <th class="text-center" >مبلغ مصرف شده</th>
                            <th class="text-center" >اعتبار باقی مانده</th>
                            </thead>
                            <tbody>
                            @foreach($vappassigns as $vappassign)
                                <tr>
                                    <td>{{$vappassign->source_name}}</td>
                                    <td>{{number_format($vappassign->approved_price)}}</td>
                                    <td>{{number_format($vappassign->price)}}</td>
                                    <td>{{$vappassign->sum_spent?number_format($vappassign->sum_spent):0}}</td>
                                    <td>{{$vappassign->sum_spent?number_format($vappassign->price-$vappassign->sum_spent):number_format($vappassign->price)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>

            <hr>

            <h1 class="text-center " style="  border-bottom: 2px solid #2fb6cc;color: #3490dc">انتخاب فعالیت :</h1>
            <hr>

            <div class="row">
                @foreach($actions as $action)
                    <div class="card bg-dark text-white " style="width: 24.5%;margin:1px;min-width: 300px;" >
                        <a href="{{url('/actions/'.$action->id)}}" class=" card-link text-white"><div class="card-header ">
                            <h4 class="card-title text-center"><i class="fa fa-list-alt icon" style="padding-left: 2px;color: #19acff;"></i>  {{$action->name}}</h4>
                        </div>
                        <div class="card-body ">
                            <p>اعتبار باقیمانده:<span class="bg-primary text-white" style=" margin: 5px; padding-left:5px; padding-right:5px;Border-radius:5px;"> {{number_format($action->price_total-$action->spent_total)}}</span></p>
                            <p><span class="accent">ریزفعالیت ها : </span></p>
                            @foreach($action->subactions as $subaction )
                                <p><i class="fa fa-tag icon" style="padding-left: 2px;color: #19acff;"></i>
                                    {{$subaction->name}}
                                </p>
                            @endforeach
                        </div></a>
                    </div>
                   {{-- <div class="col-sm-3" style="background-color:lavender;">
                        <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive"
                             style="width:100%" alt="Image">
                       <a href="{{url('/actions/'.$action->id)}}"> {{$action->name}}</a>
                    </div>--}}
                @endforeach
            </div>
        </div>
    </div>
@endsection
