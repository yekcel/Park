@extends('layouts.app')

@section('title')
    گزارش عملکرد واحد های فناورد پارک
@endsection

@section('content')

    <div class="card bg-light text-dark ">
        <div class="card-header bg-primary text-white" style="background: linear-gradient(90deg,#2991f6,#041a39); ">
            <div class="row">
                <div class="col-sm-10"><h5><i class="fa fa-file-text icon" style="padding-left: 2px;"></i> گزارش عملکرد واحد های فناور پارک</h5></div>
                <div class="col-sm-2"><a href="{{url('/reports/')}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;font-size: 150%"></i> بازگشت</a>
                </div>
            </div>
        </div>

        <div class="card-body ">
            <div class="card bg-secondary text-white " style="background-color:#798696; margin-bottom: 5px; ">
                <div class="card-header"> فیلتر گزارش</div>
                <div class="card-body ">
                    <form action="{{'/reports/fanreport'}}" method="post" class="form-inline">
                        {{ csrf_field() }}
                        <div  style="width: 100%">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group" style="padding-top: 10px">
                                                <label for="yearip">سال بودجه</label>
                                                <select name="yearip" class="form-control" id="yearip">
                                                    <option value="">لطفا سال تصویب بودجه را انتخاب نمایید...</option>
                                                    @foreach($yearts as $year)
                                                        <option value="{{$year->name}}" @if($year->name==$year1) selected @endif>{{$year->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group" style="padding-top: 10px">
                                                <label for="give_date">تاریخ هزینه از</label>
                                                <input type="text" name="give_date" class="form-control" id="give_date_picker" value="{{verta($d1)->format("Y/n/j")}}">

                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group" style="padding-top: 10px;">
                                                <label for="start_date">تا</label>
                                                <input type="text" name="start_date" class="form-control"
                                                       id="start_date_picker"  value="{{verta($d2)->format("Y/n/j")}}">

                                            </div>
                                        </div>
                                    </div>
                                </div >
                                <div class="col-md-2 ">
                                    <button type="submit" class="btn btn-outline-light " style="background: linear-gradient(90deg,#2583ee,#712f90);float: left "><i class="fa fa-filter icon" style="padding-left: 2px;font-size: 150%"></i> اعمال فیلتر</button>
                                </div>
                            </div>

                        </div>
                    </form>


                </div>
                <div class=" card-footer ">
                    <div class=" float-left">
                        <form action="{{'/reports/vahedsfanExport'}}" method="post" class="form-inline">
                            {{ csrf_field() }}
                            <input type="text" name="year1" class="form-control" id="year1" hidden="hidden"
                                   value="{{ $year1 }}">
                            <input type="text" name="d1" class="form-control" id="d1" hidden="hidden"
                                   value="{{ $d1 }}">
                            <input type="text" name="d2" class="form-control" id="d2" hidden="hidden"
                                   value="{{ $d2 }}">


                            <button type="submit" class="btn btn-success"><i class="fa fa-file-excel-o icon" style="padding-left: 2px;font-size: 150%"></i>خروجی اکسل</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">ردیف</th>
                        <th class="text-center"> نام واحد</th>
                        <th class="text-center">عنوان گرنت</th>
                        <th class="text-center">اعتبار مصوب</th>
                        <th class="text-center">اعتبار تخصیص یافته</th>
                        <th class="text-center">مبلغ هزینه( ریال)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total_allocate=0;?>
                    <?php $total_spent=0;?>
                    <?php $i = 0;  ?>
                    {{-- @foreach($subaction->spent->all() as $spent)--}}
                    @foreach($contracts as $contract)

                        <?php $i++;  ?>
                        <tr class="text-center">

                            <td><?php echo $i;  ?></td>
                            <td>{{$contract->company->name}}</td>
                            @if($contract->tittle==1)
                                <td>قرارداد پشتیبانی</td>
                            @elseif($contract->tittle==2)
                                <td>سیدمانی</td>
                            @elseif($contract->tittle==3)
                                <td>کانون شکوفایی</td>
                            @elseif($contract->tittle==4)
                                <td>هسته تحقیقاتی دانشگاهی</td>
                            @elseif($contract->tittle==5)
                                <td>تجاری سازی</td>
                            @endif
                            <td>{{$contract->totalcredit?($contract->totalcredit):0}}</td>

                            <td>
                                <?php $con=0;?>
                                @foreach($contract->conassign as $conassign)
                                    @if($conassign->year==$year1)

                                        <?php    $con=  $con+$conassign->price ?>
                                        <?php    $total_allocate=  $total_allocate+$conassign->price ?>

                                    @endif
                                @endforeach
                                {{number_format($con)}}
                            </td>
                            <td><?php $sum_spent=0;?>

                                @foreach($contract->spent as $spent)
                                    @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                        <?php   $sum_spent= $sum_spent+$spent->price ?>
                                    @endif
                                @endforeach

                                {{number_format($sum_spent)}}
                                <?php    $total_spent=  $total_spent+$sum_spent?>
                            </td>


                        </tr>

                    @endforeach
                    <tr class="bg-dark text-white text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>مجموع</td>
                        <td>{{ number_format($total_allocate)}}</td>
                        <td>{{ number_format($total_spent)}}</td>

                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="row">
                <div class="col-sm4 offset-5">
                    {{$contracts->appends(Request::only(['year','d1','d2']))->links()}}
                </div>
            </div>


        </div>
    </div>


@endsection


