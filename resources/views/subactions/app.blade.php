@extends('layouts.app')

@section('title')
    ریزفعالیت {{$subaction->name}}
@endsection

@section('content')

    <div class="card" style="border-color: #3490dc ">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9"><h5 class="text-primary"> ثبت هزینه ها <span style="color: #2fcc71" ><b> > </b></span> {{ $subaction->action->application->name }}  <span style="color: #2fcc71" ><b> > </b></span>  {{ $subaction->action->name }}  <span style="color: #2fcc71" ><b> > </b></span>{{ $subaction->name }}  </h5></div>
                <div class="col-md-3"><a href="{{url('actions/'.$subaction->action_id)}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
                    <a href="{{url('select_year')}}" class="btn btn-dark btn-xs"><i class="fa fa-calendar-check-o icon" style="padding-left: 2px;"></i> بازگشت به انتخاب سال مالی</a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container" >
            <div class="card">
                <div class="card-header bg-info text-white " style="background: linear-gradient(90deg,#183468,#150f50); "><i class="fa fa-info-circle icon" style="padding-left: 2px;"></i> اعتبارات سال<span class="bg-dark text-success"style=" margin: 5px;  padding-right:5px;Border-radius:5px;">{{session('year')}}</span></div>
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
                            @foreach($vsubtassigns as $vsubtassign)
                                <tr>
                                    <td>{{$vsubtassign->source_name}}</td>
                                    <td>{{number_format($vsubtassign->approved_price)}}</td>
                                    <td>{{number_format($vsubtassign->price)}}</td>
                                    <td>{{$vsubtassign->sum_spent?number_format($vsubtassign->sum_spent):0}}</td>
                                    <td>{{$vsubtassign->sum_spent?number_format($vsubtassign->price-$vsubtassign->sum_spent):number_format($vsubtassign->price)}}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
            </div>
            <h1 class="text-center " style="  border-bottom: 2px solid #2fb6cc;;color: #3490dc">انتخاب هزینه :</h1>
            <hr>
            <div class="row">
                @foreach($subaction->costs as $cost)
                    @if($subaction->action->application->id==3)
                        <div class="form-group" style="margin:5px;" >

                            <a class="btn btn-warning" href="{{url('/contracts/'.$subaction->id.'/'.$cost->id)}}"><i class="fa fa-handshake-o  icon" style="padding-left: 3px;"></i> {{$cost->name}} ({{$cost->cost_code}})</a>

                        </div>
                     @else
                    <div class="form-group" style="margin:5px;" >

                        <a class="btn btn-outline-dark" href="{{url('/spents/'.$subaction->id.'/'.$cost->id)}}"><i class="fa fa-file-text icon" style="padding-left: 3px;"></i> {{$cost->name}} ({{$cost->cost_code}}) <br/>
                            @foreach($costinfs as $costinf)
                               @if($cost->id==$costinf->id)
                                   <span class="text-primary"> {{$costinf->price_total}}</span>

                                @endif
                                @endforeach
                        </a>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>


<div class="card" style="border-color: #3490dc;margin: 2px ">
    <div class="card-header bg-info text-white">
        <div class="row">
            @if($subaction->action->application->id==3)
                <div class="col-sm-10"><h5><i class="fa fa-handshake-o  icon" style="padding-left: 3px;"></i> لیست قراداد ها</h5></div>
                @else
                <div class="col-sm-10"><h5>لیست هزینه ها</h5></div>
                @endif
        </div>

    </div>
    <div class="card-body">
        @if($subaction->action->application->id==3)
            <div class="table-responsive">

                <table class="table  table-striped table-hover table-bordered">
                    <thead>
                    <tr class="bg-primary text-white" >
                        <th class="text-center">شماره</th>
                        <th class="text-center">شماره قرارداد</th>
                        <th class="text-center">طرف قرارداد</th>
                        <th class="text-center">موضوع قرارداد</th>
                        <th class="text-center">تاریخ انعقاد قرارداد</th>
                        <th class="text-center">مبلغ مصوب قرارداد</th>
                        <th class="text-center">مبلغ پرداخت شده از سال قبل</th>
                        <th class="text-center">مبلغ متمم قرارداد</th>
                        <th class="text-center">مجموع پرداخت های انجام شده</th>
                        <th class="text-center">نوع هزینه</th>

                        <th class="text-center">توضیحات</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>

                    <tbody>


                    {{-- @foreach($subaction->spent->all() as $spent)--}}
                    <?php $index=0; ?>
                    @foreach($contracts as $contract)
                        <?php $index++; ?>
                        <tr class="text-center" <?php if($contract->status==3) echo 'style="background-color: #5a6268"';?>>

                          {{--  <td>{{$contract->id}}</td>--}}
                            <td>{{$index}}</td>
                            <td>{{$contract->num}}</td>
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


                            <td>{{$contract->date?Verta::instance($contract->date)->formatJalaliDate():null}}</td>
                            <td>{{number_format($contract->totalcredit)}}</td>
                            <td>{{$contract->paid_befor?number_format($contract->paid_befor):0}}</td>
                            <td>{{$contract->motamem?number_format($contract->motamem):0}}</td>
                            <td>{{$contract->spent?number_format($contract->spent->sum('price')):null}}</td>
                            <td>{{$contract->cost->name}}({{$contract->cost->cost_code}})</td>

                            <td>{{$contract->comments}}</td>
                            <td>
                                @if($contract->status<3)
                                    <a href="{{url('contracts/edit/'.$contract->id)}}"
                                       class="btn btn-warning "><i class="fa fa-edit icon" style="padding-left: 2px;"></i>ویرایش</a>

                                    {{--<a href="{{url('checklists/delete/'.$cooling->id)}}"
                                       class="btn btn-danger btn-xs" style="width:50px">حذف</a>--}}
                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                            data-target="#deletemodal<?php echo $contract->id; ?>"><i class="fa fa-trash-o icon" style="padding-left: 2px;"></i> حذف
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="deletemodal<?php echo $contract->id; ?>"
                                         tabindex="-1" role="dialog" >
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white" >
                                                    <p class="modal-title" style="margin: 0 auto;" >قرارداد انتخاب شده حذف گردد؟</p>

                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped teacherInfo">

                                                        <tr>
                                                            <th>شماره قرارداد :</th>
                                                            <td>{{$contract->num}}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>موضوع قرارداد :</th>
                                                            <td>{{$contract->tittle}}</td>

                                                        </tr>
                                                        <tr>
                                                            <th>تاریخ قرارداد :</th>
                                                            <td>{{$contract->date}}</td>

                                                        </tr>
                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{url('contracts/delete/'.$contract->id)}}"
                                                       class="btn btn-danger " style="width:80px">حذف</a>
                                                    <button type="button" class="btn btn-success"
                                                            data-dismiss="modal">بازگشت
                                                    </button>
                                                    <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--end modal--}}
                                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModalLong<?php echo $contract->id; ?>"><i class="fa fa-plus-circle icon" style="padding-left: 2px;"></i> متمم قرارداد
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong<?php echo $contract->id; ?>" tabindex="-1" role="dialog" >
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">متمم قرارداد شماره {{$contract->num }}</h5>

                                                </div>
                                                <div class="modal-body">

                                                    <form action="{{'/contracts/motamem/'.$contract->id }}" method="post" class="form-inline">
                                                        {{ csrf_field() }}
<div class="container">
                                                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                            <label for="price" >مبلغ متمم*</label>

                                                                <input type="text" name="price" class="form-control" id="price"
                                                                       placeholder="لطفا مبلغ متمم را وارد نمایید"
                                                                       value="{{ $errors->has('price')?old('price'):$contract->motamem }}">ریال

                                                        </div>
                                                        <div class="row" style="margin-top: 5px">
                                                        <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                                                            <label for="year" >سال مالی اعتبار متمم* </label>

                                                                <select name="year" class="form-control" id="year">
                                                                    <option value="">لطفا سال مالی متمم قرارداد را انتخاب نمایید...</option>
                                                                    @foreach($yearts as $year)
                                                                        <option value="{{$year->name}}"@if ($year->name == $contract->motamemyear) selected="selected" @endif>{{$year->name}}</option>
                                                                    @endforeach
                                                                </select>

                                                                @if ($errors->has('year'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                                                @endif
                                                        </div>
                                                        </div>
                                                        <div class="row" style="margin-top: 5px">
                                                            <div>
                                                            <button type="submit" class="btn btn-primary" >ذخیره</button>
                                                            </div>
                                                        </div>
</div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--end modal--}}
                                    <a href="{{url('contracts/'.$contract->id.'/show')}}"
                                       class="btn btn-primary "><i class="fa fa-eye icon" style="padding-left: 2px;"></i> نمایش و پرداخت</a>
                                @else
                                    حذف شده

                                @endif

                            </td>

                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {{ $contracts->links() }}
            </div>
                    @else{{----------------------------------------------------------------------------------------------------}}
      <div class="table-responsive">

        <table class="table table-striped table-hover table-bordered">
            <thead>

                <tr class=" bg-primary text-white">
                    <th class="text-center">شماره هزینه</th>
                    <th class="text-center"> شماره سند</th>
                    <th class="text-center">نوع هزینه</th>
                    <th class="text-center">موضوع هزینه</th>
                    <th class="text-center">مبلغ هزینه</th>
                    <th class="text-center">تاریخ هزینه</th>
                    <th class="text-center">منبع درآمد</th>
                    <th class="text-center">نوع مصرف</th>
                    <th class="text-center">شرکت های ذینفع</th>
                    <th class="text-center">توضیحات</th>
                    <th class="text-center">عملیات</th>


                </tr>



            </thead>
            <tbody>


           {{-- @foreach($subaction->spent->all() as $spent)--}}
           <?php $index=0; ?>
                @foreach($spents as $spent)
                <tr class="text-center" <?php if($spent->status==3) echo 'style="background-color: #5a6268"';?>>
                    <?php $index++; ?>
                    <td>{{$index}}</td>
                    <td>{{$spent->doc_number}}</td>
                    <td>{{$spent->cost->name}}({{$spent->cost->cost_code}})</td>
                    <td>{{$spent->name}}</td>

                    <td>{{$spent->price?number_format($spent->price):null}}</td>
                    <td>{{$spent->spend_date?Verta::instance($spent->spend_date)->formatJalaliDate():null}}</td>

                    <td>{{$spent->credit?$spent->credit->source->name:null}}</td>
                    <td>{{$spent->credit?$spent->credit->name:null}}</td>
                    <td>
                        @foreach($spent->company as $company)
                            {{$company->name}}
                            <br>
                            @endforeach
                    </td>
                    <td>{{$spent->comments}}</td>
                    <td>
                        @if($spent->status<3)
                            <a href="{{url('spents/'.$spent->id.'/edit')}}"
                               class="btn btn-warning btn-xs"><i class="fa fa-edit icon" style="padding-left: 3px;"></i> ویرایش</a>

                            {{--<a href="{{url('checklists/delete/'.$cooling->id)}}"
                               class="btn btn-danger btn-xs" style="width:50px">حذف</a>--}}
                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                    data-target="#deletemodal<?php echo $spent->id; ?>"><i class="fa fa-trash-o icon" style="padding-left: 3px;"></i> حذف
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="deletemodal<?php echo $spent->id; ?>"
                                 tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                 aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <p class="modal-title" style="margin: 0 auto;" >هزینه انتخاب شده حذف گردد؟</p>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped teacherInfo">

                                                <tr>
                                                    <th>شماره هزینه :</th>
                                                    <td>{{$spent->id}}</td>
                                                </tr>

                                                <tr>
                                                    <th>نوع هزینه :</th>
                                                    <td>{{$spent->cost->name}}</td>

                                                </tr>
                                                <tr>
                                                    <th>شماره سند :</th>
                                                    <td>{{$spent->doc_number}}</td>

                                                </tr>
                                            </table>

                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{url('/spents/deleteSpent/'.$spent->id)}}"
                                               class="btn btn-danger " style="width: 150px"><i class="fa fa-trash-o icon" style="padding-left: 3px;"></i> حذف</a>
                                            <button type="button" class="btn btn-success"
                                                    data-dismiss="modal" style="width: 150px"><i class="fa fa-rotate-right icon" style="padding-left: 3px;"></i> بازگشت
                                            </button>
                                            <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--end modal--}}
                            @else
                            حذف شده

                        @endif


                    </td>

                </tr>

            @endforeach

            </tbody>
        </table>
      </div>
      <div class="text-center">
            {{ $spents->links() }}
      </div>
        @endif
    </div>
</div>

@endsection
