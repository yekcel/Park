@extends('layouts.app')

@section('title')
    لیست برنامه ها
@endsection
@section('style')

@endsection
@section('content')

    <div class=" card bg-white" style="border-color: #3490dc ">
        <div class="card-header " >
            <div class="row">
                <div class="col-sm-9 "><h5 class="text-primary"> ثبت هزینه ها</h5></div>
                <div class="col-sm-3"><a href="{{url('select_year')}}" class="btn btn-dark btn-xs" ><i class="fa fa-calendar-check-o icon" style="padding-left: 2px;"></i> بازگشت به انتخاب سال مالی</a>

            </div>
        </div>
        </div>
        <div class="card-body">
            <div class="container">
            <div class="card bg-light ">
                <div class="card-header text-white " style="background: linear-gradient(90deg,#183468,#150f50); "><i class="fa fa-info-circle icon" style="padding-left: 2px;"></i> اعتبارات سال  <span class="bg-dark text-success"style=" margin: 5px;  padding-right:5px;Border-radius:5px;">{{$year}}</span></div>
                <div class="card-body">
                    <div class="row  ">


                        <table class="table table-bordered table-striped table-hover ">
                            <thead class="bg-primary text-white" >

                            <th class="text-center" >عنوان بودجه</th>
                            <th class="text-center" >مبلغ مصوب</th>
                            <th class="text-center" >مبلغ اعتبار</th>
                            <th class="text-center" >مبلغ مصرف شده</th>
                            <th class="text-center" >اعتبار باقی مانده</th>
                            </thead>
                            <tbody>
                            @foreach($vbudgets as $vbudget)
                                <tr>
                                    <td>{{$vbudget->source->name}}</td>
                                    <td>{{number_format($vbudget->approved_price)}}</td>
                                    <td>{{number_format($vbudget->price)}}</td>
                                    <td>{{number_format($vbudget->sum_spent)}}</td>
                                    <td>{{number_format($vbudget->price-$vbudget->sum_spent)}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
            <hr>
            <div>
            <h1 class="text-center " style="  border-bottom: 2px solid #3490dc ;color: #3490dc ">انتخاب برنامه :</h1>
            <hr>

            <div class="row" >

@foreach($applications as $application )

                    <div class="card bg-dark text-white ui-state-default " style="width: 24.5%;margin:1px;min-width: 300px;" >
                        <a  href="{{url('/applications/'.$application->id)}}" class="card-link text-white"><div class="card-header ">
                            <h4 class="card-title text-center"><i class="fa fa-list-alt icon" style="padding-left: 2px;color: #19acff;"></i> {{$application->name}}</h4>
                        </div>
                        <div class="card-body ">
                            <p>اعتبار باقیمانده:<span class="bg-primary text-white" style=" margin: 5px; padding-left:5px; padding-right:5px;Border-radius:5px;"> {{number_format($application->price_total-$application->spent_total)}}</span></p>
                            <p><span class="accent">فعالیت ها : </span></p>
                            @foreach($application->action as $action )
                                <p><i class="fa fa-tag icon" style="padding-left: 2px;color: #19acff;"></i>
                                    {{$action->name}}
                                </p>
                                @endforeach

                        </div></a>
                    </div>
              {{--  <div class="col-sm-3" style="background-color:lavender;">
                    <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive"
                         style="width:100%" alt="Image">
                    <td></td>
                   </div>--}}
    @endforeach
            </div>
            </div>
        </div>
    </div>
@endsection

