@extends('layouts.app')

@section('title')
    گزارش عملکرد سه ماهه واحد های فناور رشد
@endsection

@section('content')

    <div class="card bg-light text-dark ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">گزارش عملکرد سه ماهه واحد های فناور رشد</div>

            </div>
        </div>

        <div class="card-body ">
            <div class="card bg-secondary text-white ">
                <div class="card-header"> فیلتر گزارش</div>
                <div class="card-body ">
                    <form action="{{'/reports/Roshd'}}" method="post" class="form-inline">
                        {{ csrf_field() }}
                        <div class="container">
                            <div class="row">

                                <div class="col-sm6">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="season">سه ماهه</label>
                                        <select name="season" class="form-control" id="season">
                                            <option value="1" @if($season1==1) selected @endif >اول</option>
                                            <option value="2" @if($season1==2) selected @endif>دوم</option>
                                            <option value="3" @if($season1==3) selected @endif>سوم</option>
                                            <option value="4" @if($season1==4) selected @endif>چهارم</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm6">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="year">سال هزینه</label>
                                        <select name="year" class="form-control" id="year">
                                            @foreach($yearts as $year)
                                                <option value="{{$year->name}}" @if($year->name==$year1) selected @endif>{{$year->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">اعمال فیلتر</button>
                            </div>
                        </div>


                    </form>


                </div>
            </div>
            <div class="row justify-content-end" style="margin:15px;">
                <div class="col-sm-2 ">
                    <form action="{{'/reports/export2'}}" method="post" class="form-inline">
                        {{ csrf_field() }}
                        <input type="text" name="season1" class="form-control" id="season1" hidden="hidden"
                               value="{{ $season1 }}">

                        <input type="text" name="year1" class="form-control" id="year1" hidden="hidden"
                               value="{{ $year1 }}">

                        <button type="submit" class="btn btn-success">خروجی اکسل</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">ردیف</th>
                        <th class="text-center"> نام واحد</th>
                        <th class="text-center">عنوان گرنت</th>
                        <th class="text-center">اعتبار مصوب</th>
                        <th class="text-center">اعتبار تخصیص یافته</th>
                        <th class="text-center">مبلغ هزینه(میلیون ریال)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;  ?>
                    {{-- @foreach($subaction->spent->all() as $spent)--}}
                    @foreach($contracts as $contract)
                        @if($contract->company->kind==1)
                            <?php $i++;  ?>
                            <tr class="text-center">

                                <td><?php echo $i;  ?></td>
                                <td>{{$contract->company->name}}</td>
                                @if($contract->tittle==1)
                                    <td>قرارداد پشتیبانی</td>
                                @elseif($contract->tittle==2)
                                    <td>سیدمانی</td>
                                @endif
                                <td>{{$contract->totalcredit}}</td>

                                <td>

                                    @foreach($contract->conassign as $conassign)
                                        @if($conassign->year==$year1)
                                            {{$conassign->price}}
                                        @endif
                                    @endforeach
                                </td>
                                <td><?php $sum_spent=0;?>

                                    @foreach($contract->spent as $spent)
                                        @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                            <?php   $sum_spent= $sum_spent+$spent->price ?>
                                        @endif
                                    @endforeach

                                    {{$sum_spent}}

                                </td>


                            </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>

            </div>
            <div class="row">
                <div class="col-sm4 offset-5">
                    {{$contracts->appends(Request::only(['year','season']))->links()}}
                </div>
            </div>

            {{--@include('reports.export1',$exspents)--}}
        </div>
    </div>


@endsection


