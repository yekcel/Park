@extends('layouts.app')

@section('title')
     فعالیت   {{$action->name}}
@endsection

@section('content')

    <div class=" card bg-white" style="border-color: #3490dc ">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9"><h5 class="text-primary"> ثبت هزینه ها <span style="color: #2fcc71" ><b> > </b></span>{{ $action->application->name }}  <span style="color: #2fcc71" ><b> > </b></span>  {{ $action->name }}  </h5></div>
                <div class="col-sm-3"><a href="{{url('/applications/'.$action->application->id)}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
                    <a href="{{url('select_year')}}" class="btn btn-dark btn-xs"><i class="fa fa-calendar-check-o icon" style="padding-left: 2px;"></i> بازگشت به انتخاب سال مالی</a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
            <div class="card ">
                <div class="card-header bg-info text-white " style="background: linear-gradient(90deg,#183468,#150f50); "><i class="fa fa-info-circle icon" style="padding-left: 2px;"></i>  اعتبارات سال<span class="bg-dark text-success"style=" margin: 5px;  padding-right:5px;Border-radius:5px;">{{session('year')}}</span></div>
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
                            @foreach($vactassigns as $vactassign)
                                <tr>
                                    <td>{{$vactassign->name}}</td>
                                    <td>{{number_format($vactassign->approved_price)}}</td>
                                    <td>{{number_format($vactassign->price)}}</td>
                                    <td>{{$vactassign->sum_spent?number_format($vactassign->sum_spent):0}}</td>
                                    <td>{{$vactassign->sum_spent?number_format($vactassign->price-$vactassign->sum_spent):number_format($vactassign->price)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>
            <hr>
            <h1 class="text-center " style="  border-bottom: 2px solid #2fb6cc;;color: #3490dc">انتخاب ریز فعالیت :</h1>
            <hr>
            <div class="row">
                @foreach($subactions as $subaction)
                    <div class="card bg-dark text-white " style="width: 24.5%;margin:1px;min-width: 300px;" >
                        <a href="{{url('/subactions/'.$subaction->id)}}" class="text-white card-link">   <div class="card-header ">
                            <h4 class="card-title text-center"><i class="fa fa-list-alt icon" style="padding-left: 2px;color: #19acff;"></i>  {{$subaction->name}}</h4>
                        </div>
                            <div class="card-body ">
                                <p>اعتبار باقیمانده:<span class="bg-primary text-white" style=" margin: 5px; padding-left:5px; padding-right:5px;Border-radius:5px;"> {{number_format($subaction->price_total-$subaction->spent_total)}}</span></p>

                            </div>
                       </a>
                    </div>

                {{--    <div class="col-sm-3" style="background-color:lavender;">
                        <img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive"
                             style="width:100%" alt="Image">
                        <a href="{{url('/subactions/'.$subaction->id)}}"> {{$subaction->name}} ({{$subaction->subaction_code}})</a>
                    </div>--}}
                @endforeach
            </div>
        </div>
    </div>
@endsection
