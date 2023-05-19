@extends('layouts.app')

@section('title')
    گزارش هزینه ریزفعالیت ها
@endsection

@section('content')

    <div class="card bg-light text-dark ">
        <div class="card-header bg-primary text-white" style="background: linear-gradient(90deg,#2991f6,#041a39); ">
            <div class="row">
                <div class="col-sm-10"><h5><i class="fa fa-file-text icon" style="padding-left: 2px;"></i>  گزارش هزینه ریزفعالیت ها</h5></div>
                <div class="col-sm-2"><a href="{{url('/reports/')}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;font-size: 150%"></i> بازگشت</a>
                </div>
                </div>
        </div>
        <div class="card-body " >

            <div class="card bg-secondary text-white " style="background-color:#798696; margin-bottom: 5px; ">
                <div class="card-header"> فیلتر گزارش</div>
                <div class="card-body ">
                    <form action="{{'/reports/subcredit'}}" method="post" class="form-inline">
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
                        <form action="{{'/reports/subCreditExport'}}" method="post" class="form-inline">
                            {{ csrf_field() }}
                            <input type="text" name="year1" class="form-control" id="year1" hidden="hidden"
                                   value="{{ $year1 }}">
                            <input type="text" name="d1" class="form-control" id="d1" hidden="hidden"
                                   value="{{ $d1 }}">
                            <input type="text" name="d2" class="form-control" id="d2" hidden="hidden"
                                   value="{{ $d2 }}">


                            <button type="submit" class="btn btn-success" style="margin-top: 5px"><i class="fa fa-file-excel-o icon" style="padding-left: 2px;font-size: 150%"></i> خروجی اکسل</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">سال مالی</th>
                        <th class="text-center">ریزفعالیت</th>
                        <th class="text-center">هزینه</th>
                        <th class="text-center">محل تامین اعتبار</th>
                        <th class="text-center">مبلغ هزینه کرد(ریال)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $total_allocate=0;?>
                    <?php $total_budget=0;?>
                    @foreach($subactions as $subaction)
                        @foreach($subaction->costs as $cost)
                            <?php $ind=0; ?>
                    @foreach($vsubcredits as $vsubcredit)
@if($vsubcredit->cost_id== $cost->id && $vsubcredit->sub_id==$subaction->id)
    <?php $ind++; ?>
                        <tr class="text-center">
                            <td>{{$vsubcredit->year}}</td>
                            <td>{{$vsubcredit->subaction}}</td>
                            <td>{{$vsubcredit->cost}}</td>
                            <td>{{$vsubcredit->credit_name}}</td>
                            <td>{{$vsubcredit->sum?number_format($vsubcredit->sum):0}}</td>
                            <?php    $total_allocate=  $total_allocate+$vsubcredit->sum ?>
                        </tr>
                        @endif

                    @endforeach
                            @if($ind==0)
                                <tr class="text-center">
                                    <td>{{$year1}}</td>
                                    <td>{{$subaction->name}}</td>
                                    <td>{{$cost->name}}</td>
                                    <td>-</td>
                                    <td>0</td>

                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                    <tr class="bg-dark text-white text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>مجموع</td>
                        <td>{{number_format( $total_allocate)}}</td>
                    </tr>
                    </tbody>
                </table>

            </div>


            {{--@include('reports.export1',$exspents)--}}
        </div>
    </div>


@endsection


