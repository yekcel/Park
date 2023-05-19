@extends('layouts.app')

@section('title')
    گزارش بودجه و اعتبار ریزفعالیت ها
@endsection

@section('content')

    <div class="card">
        <div class="card-header bg-primary text-white" style="background: linear-gradient(90deg,#2991f6,#041a39); ">
            <div class="row">
                <div class="col-sm-10"><i class="fa fa-file-text icon" style="padding-left: 2px;font-size: 150%"></i>  گزارش بودجه و اعتبار ریزفعالیت ها</div>
                <div class="col-sm-2"><a href="{{url('/reports/')}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
                </div>
                </div>
        </div>

        <div class="card-body ">
            <div class="card bg-secondary text-white "  style="background-color:#798696; margin-bottom: 5px; ">
                <div class="card-header ">
                    <div class="row">
                    <div class="col-sm-10"> فیلتر گزارش</div>
                    <div class="col-sm-2">
                        <div class=" float-left">
                            <form action="{{'/reports/export2'}}" method="post" >
                                {{ csrf_field() }}
                                <input type="text" name="year1" class="form-control" id="year1" hidden="hidden"
                                       value="{{ $year1 }}">
                                <input type="text" name="d1" class="form-control" id="d1" hidden="hidden"
                                       value="{{ $d1 }}">
                                <input type="text" name="d2" class="form-control" id="d2" hidden="hidden"
                                       value="{{ $d2 }}">


                                <button type="submit" class="btn btn-success" style="width: 150px"><i class="fa fa-file-excel-o icon" style="padding-left: 2px;font-size: 150%"></i>خروجی اکسل</button>
                            </form>
                        </div>
                    </div>
                        </div>
                </div>
                <div class="card-body ">
                    <div class="row">
                        <div class="col">
                    <form action="{{'/reports/subbudget'}}" method="post" class="form-inline">
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
                                    <button type="submit" class="btn btn-outline-light " style="float: left;width: 150px "><i class="fa fa-filter icon" style="padding-left: 2px;font-size: 150%"></i> اعمال فیلتر</button>
                                </div>
                            </div>

                        </div>
                    </form>


                </div>

            </div>
                </div>


            </div>



            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">شماره</th>
                     {{--   <th class="text-center">عنوان برنامه</th>
                        <th class="text-center">عنوان فعالیت</th>--}}
                        <th class="text-center">عنوان ریزفعالیت</th>
                        <th class="text-center">واحد مجری</th>
                        <th class="text-center">تصویب(ریال)</th>
                        <th class="text-center">تخصیص(ریال)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;  ?>
                    <?php $total_allocate=0;?>
                    <?php $total_budget=0;?>
                    {{-- @foreach($subaction->spent->all() as $spent)--}}
                    @foreach($subactions as $subaction)
                        <?php $i++;
                        if($subaction->price_total){
                            $total_budget=$total_budget+ $subaction->price_total;
                        }
                        ?>
                        <tr class="text-center">

                            <td><?php echo $i;  ?></td>
                          {{--  <td>{{$subaction->action->application->name}}</td>
                            <td>{{$subaction->action->name}}</td>--}}
                            <td>{{$subaction->name}}</td>
                            <td>{{$subaction->agent}}</td>
                            <td>{{$subaction->price_total?number_format($subaction->price_total):0}}</td>
                            <td>
                                <?php $sum_allocate=0;?>
                                    @foreach($subaction->subassign as $subassign)
                                        @if($subassign->actassign->appassign->budget->year==$year1 )
                                @foreach($subassign->allocate as $allocate)
                                    @if($allocate->allocate_date>=$d1 && $allocate->allocate_date<=$d2 )
                                        <?php   $sum_allocate= $sum_allocate+$allocate->allocate_price ?>
                                    @endif
                                @endforeach
                                        @endif
                                    @endforeach
                                    <?php    $total_allocate=  $total_allocate+$sum_allocate ?>

                                {{number_format($sum_allocate)}}

                            </td>



                        </tr>

                    @endforeach
<tr class="bg-dark text-white text-center">
    <td></td>
    <td></td>
    <td>مجموع</td>
    <td>{{ number_format($total_budget)}}</td>
    <td>{{ number_format($total_allocate)}}</td>
</tr>
                    </tbody>
                </table>

            </div>


            {{--@include('reports.export1',$exspents)--}}
        </div>
    </div>


@endsection


