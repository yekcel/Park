@extends('layouts.app')

@section('title')
    نمایش قرارداد شماره {{$contract->num}}
@endsection

@section('content')
    <div class=" card bg-white">
        <div class="card-header bg-info text-white">
            <div class="row">
                <div class="col-md-10">

                    <h5><i class="fa fa-handshake-o  icon" style="padding-left: 2px;"></i>     قرارداد -{{$contract->subaction->name}} </h5>
                </div>
                <div class="col-md-2">
                    <a href="{{url('/subactions/'.$contract->subaction_id)}}"class="btn btn-dark"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
                        </a>
                </div>
            </div>
        </div>


        <div class="card-body" >
            <table class="table table-striped teacherInfo">

                <tr>
                    <th>شماره قرارداد :</th>
                    <td>{{$contract->num}}</td>
                    <th>تاریخ انعقاد قرارداد :</th>
                    <td>{{$contract->date?Verta::instance($contract->date)->formatJalaliDate():null}}</td>
                    <th>عنوان قرارداد :</th>
                    <td>
                        @if($contract->tittle==1)
                            قرارداد پشتیبانی
                        @elseif($contract->tittle==2)
                            سیدمانی
                        @elseif($contract->tittle==3)
                            کانون شکوفایی
                        @elseif($contract->tittle==4)
                            هسته دانشگاهی
                        @elseif($contract->tittle==5)
                            تجاری سازی
                            @endif
                    </td>

                </tr>
                <tr>
                    <th>واحد فناور طرف قرارداد :</th>
                    <td>{{$contract->company->name}}</td>
                    <th>تاریخ شروع قرارداد :</th>
                    <td>{{$contract->date?Verta::instance($contract->date)->formatJalaliDate():null}}</td>
                    <th>مقطع پذیرش :</th>
                    <td>
                        @if($contract->level==1)
                            هسته دوره پیش رشد
                        @elseif($contract->level==2)
                            فناور دوره رشد
                        @else
                            فناور
                        @endif
                    </td>

                </tr>
                <tr>
                    <th>مدت قرارداد :</th>
                    <td>{{$contract->duration}}</td>
                    <th>مبلغ اعتبار مصوب قرارداد :</th>
                    <td>{{number_format($contract->totalcredit).' ریال'}}</td>
                    <th>مبلغ پرداخت شده از سال های قبل :</th>
                    <td>{{number_format($contract->paid_befor).' ریال'}}</td>

                </tr>
                <tr>
                    <th>توضیحات :</th>
                    <td>{{$contract->comments}}</td>

                </tr>

            </table>



            <hr>
<div class="container">
            <div class="card " style="border-color: #2a9055">
                <div class="card-header bg-success text-white text-center">اعتبارات تخصیص یافته</div>
                <div class="card-body">
                    <table class="table table-striped teacherInfo">

                        <tr>
                            <th>مجموع اعتبارات تخصیص یافته :</th>
                            <td>{{$contract->conassign?number_format( $contract->conassign->sum('price')).' ریال':0}}</td>
                            <th>باقی مانده(بدون تخصیص اعتبار) :</th>
                            <td>{{number_format($contract->totalcredit-$contract->paid_befor-$contract->conassign->sum('price')).' ریال'}}</td>


                        </tr>
                        </table>

                    <hr>
                    <div class="row">
                        <div class="col-md-9 ">
                            <table class="table table-bordered table-striped table-hover ">
                                <thead class="bg-success text-white">
                                <tr>
                                    <th class="text-center" style="width: 50%">سال</th>
                                    <th class="text-center">مبلغ</th>
                                    <th class="text-center">عملیات</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($contract->conassign as $conassign)
                                    <tr class="text-center">
                                        <td>{{$conassign->year}}</td>
                                        <td>{{$conassign->price?$conassign->price:null}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">

                                                {{--  <a href="{{url('spents/'.$spent->id.'/edit')}}"
                                                     class="btn btn-warning btn-xs">ویرایش</a>

                                                  <a href="{{url('spents/'.$spent->id.'/delete')}}"
                                                     class="btn btn-danger btn-xs">حذف</a>--}}
                                                @if($conassign->status<3)
                                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal"
                                                            data-target="#editconmodal<?php echo $conassign->id; ?>"><i class="fa fa-edit icon" style="padding-left: 2px;"></i> ویرایش
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editconmodal<?php echo $conassign->id; ?>"
                                                         tabindex="-1" role="dialog" >
                                                        <div class="modal-dialog" role="document" style="min-width: 650px">
                                                            <div class="modal-content text-right">
                                                                <div class="modal-header bg-success text-white">
                                                                    <h5 class="modal-title " style="margin: 0 auto;" id="exampleModalLongTitle">ویرایش اعتبار </h5>

                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{'/contracts/editconassign/'.$conassign->id}}" method="post" class="form-horizontal">
                                                                        {{ csrf_field() }}
                                                                        {{method_field('PATCH')}}

                                                                        <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                                                                            <label for="year" class=" control-label">سال</label>
                                                                            <div class="col-md-8">
                                                                                <select name="year" class="form-control" id="year">
                                                                                    <option value="">لطفا سال را انتخاب نمایید...</option>

                                                                                    @foreach($yearts as $year)
                                                                                        <option value="{{$year->name}}"  @if($conassign->year==$year->name) selected @endif>{{$year->name}}</option>

                                                                                    @endforeach
                                                                                </select>



                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                                            <label for="person" class=" control-label">مبلغ*</label>
                                                                            <div class="row" >
                                                                                <div class="col-md-10">
                                                                                <input type="text" name="price" class="form-control" id="price" placeholder="لطفا مبلغ اعتبار را وارد نمایید"
                                                                                       value="{{ $errors->has('price')?old('price'):$conassign->price }}">
                                                                                </div>
                                                                                <div class="col-md-2 ">ریال</div>
                                                                            </div>
                                                                                @if ($errors->has('price'))
                                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                                                                @endif


                                                                        </div>


                                                                        <div class="form-group">
                                                                            <div class="col-md-8 col-md-offset-2">
                                                                                <button type="submit" class="btn btn-success"> ثبت تغییرات </button>

                                                                            </div>
                                                                        </div>


                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">

                                                                    <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
                                                                    </button>
                                                                    <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--end modal--}}

                                                    {{--<a href="{{url('checklists/delete/'.$cooling->id)}}"
                                                       class="btn btn-danger btn-xs" style="width:50px">حذف</a>--}}
                                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                            data-target="#deleteconmodal<?php echo $conassign->id; ?>"><i class="fa fa-trash-o icon" style="padding-left: 2px;"></i> حذف
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deleteconmodal<?php echo $conassign->id; ?>"
                                                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary text-white" >
                                                                    <p class="modal-title" style="margin: 0 auto;" >تخصیص انتخاب شده حذف گردد؟</p>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>حذف اعتبار تخصیص یافته سال:     {{$conassign->year}}    </p>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="{{url('/contracts/deleteconassign/'.$conassign->id)}}"
                                                                       class="btn btn-danger ">حذف</a>
                                                                    <button type="button" class="btn btn-primary"
                                                                            data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
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
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                               {{-- <tr class="bg-dark text-white">
                                    <td>مجموع اعتبارات تخصیص یافته</td>
                                    <td>{{$contract->conassign?$contract->conassign->sum('price'):0}}</td>

                                </tr>
                                <tr class="bg-dark text-white">
                                    <td>باقی مانده(بدون تخصیص اعتبار)</td>
                                    <td>{{$contract->totalcredit-$contract->conassign->sum('price')}}</td>

                                </tr>--}}
                                </tbody>
                            </table>

                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                    data-target="#addassignmodal"><i class="fa fa-plus icon" style="padding-left: 2px;"></i> تخصیص اعتبار جدید
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="addassignmodal" tabindex="-1" role="dialog" >
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">


                                        </div>
                                        <div class="modal-body">
                                            <form action="{{'/contracts/addconassign/'.$contract->id}}" method="post" class="form-horizontal">
                                                {{ csrf_field() }}
                                                <input type="text" name="contract_id" class="form-control" id="contract_id" hidden="hidden" value="{{  $contract->id}}">
                                                <input type="text" name="subaction_id" class="form-control" id="subaction_id" hidden="hidden" value="{{  $contract->subaction_id}}">

                                                <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                                                    <label for="year" class="col-sm-4 control-label">سال</label>
                                                    <div class="col-sm-6">
                                                        <select name="year" class="form-control" id="year">
                                                            <option value="">لطفا سال را انتخاب نمایید...</option>
                                                            @foreach($yearts as $year)
                                                                <option value="{{$year->name}}">{{$year->name}}</option>
                                                            @endforeach
                                                        </select>



                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                    <label for="person" class="col-sm-4 control-label">مبلغ*</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" name="price" class="form-control" id="price"
                                                               placeholder="لطفا مبلغ اعتبار را وارد نمایید" value="{{ old('price') }}">

                                                        @if ($errors->has('price'))
                                                            <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                                        @endif

                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <button type="submit" class="btn btn-primary"> ثبت تخصیص </button>

                                                    </div>
                                                </div>


                                            </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
                                            </button>
                                            <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--end modal--}}

                    </div>
                </div>
            </div>
           {{-- <p>اعتبارات تخصیص یافته: </p>--}}
            </div>

            <div class="card" style="margin-top: 10px;border-color: #0871bd">
                <div class="card-header bg-primary text-white text-center">پرداخت های قرارداد</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9 ">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="bg-primary text-white">
                                <tr class="text-center">
                                    <th class="text-center">تاریخ</th>
                                    <th class="text-center">مبلغ</th>
                                    <th class="text-center">منبع اعتبار</th>
                                    <th class="text-center">توضیحات</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($contract->spent as $spent)
                                    <tr class="text-center">
                                        <td>{{$spent->spend_date?Verta::instance($spent->spend_date)->formatJalaliDate():null}}</td>
                                        <td>{{$spent->price?$spent->price:null}}</td>
                                        <td>{{$spent->credit?$spent->credit->source->name:null}}</td>
                                        <td>{{$spent->comments}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">


                                                @if($spent->status<3)
                                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal"
                                                            data-target="#editspentmodal<?php echo $spent->id; ?>"><i class="fa fa-edit icon" style="padding-left: 2px;"></i> ویرایش
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editspentmodal<?php echo $spent->id; ?>"
                                                         tabindex="-1" role="dialog" >
                                                        <div class="modal-dialog" role="document" style="min-width: 650px">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary text-white">
                                                                    <h5 class="modal-title" style="margin: 0 auto;" id="exampleModalLongTitle">ویرایش پرداخت </h5>

                                                                </div>
                                                                <div class="modal-body text-right">
                                                                    <form action="{{'/spents/editconspent/'.$conassign->id}}" method="post" class="form-horizontal">
                                                                        {{ csrf_field() }}
                                                                        {{method_field('PATCH')}}

                                                                        <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                                                                            <label for="give_date" class=" control-label">تاریخ پرداخت</label>
                                                                            <div >
                                                                                <input type="text" name="give_date" class="form-control" id="give_date_picker"
                                                                                       value="{{ $errors->has('give_date')?old('give_date'):Verta::instance($spent->spend_date)->formatJalaliDate() }}">

                                                                                @if ($errors->has('give_date'))
                                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('give_date') }}</strong>
                                    </span>
                                                                                @endif

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group{{ $errors->has('source_code') ? ' has-error' : '' }}">
                                                                            <label for="source_code" class=" control-label">منبع اعتبار</label>
                                                                            <div >
                                                                                <select name="source_code" class="form-control" id="source_code">
                                                                                    <option value="">لطفا منبع اعتبار را انتخاب نمایید...</option>
                                                                                    @foreach($vsubtassigns as $vsubtassign)
                                                                                        <option value="{{$vsubtassign->id}} @if($spent->credit->source_id==$vsubtassign->id) @endif">{{$vsubtassign->source_name}} </option>
                                                                                    @endforeach
                                                                                </select>

                                                                                @if ($errors->has('source_code'))
                                                                                    <span class="help-block text-danger">
                                                                                      <strong>{{ $errors->first('source_code') }}</strong>
                                                                                    </span>
                                                                                @endif

                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                                            <label for="person" class=" control-label">مبلغ*</label>
                                                                            <div class="row" >
                                                                                <div class="col-md-10">
                                                                                <input type="text" name="price" class="form-control" id="price"
                                                                                       placeholder="لطفا مبلغ هزینه را وارد نمایید" value="{{ old('price') }}">
                                                                                </div>
                                                                                <div class="col-md-2 ">ریال</div>
                                                                            </div>
                                                                                @if ($errors->has('price'))
                                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                                                                @endif


                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="comments" class=" control-label">توضیحات</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea type="text" name="comments" class="form-control" id="comments"></textarea>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="col-md-8 col-md-offset-2">
                                                                                <button type="submit" class="btn btn-primary"> ثبت تغییرات </button>

                                                                            </div>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">

                                                                    <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
                                                                    </button>
                                                                    <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--end modal--}}

                                                    {{--<a href="{{url('checklists/delete/'.$cooling->id)}}"
                                                       class="btn btn-danger btn-xs" style="width:50px">حذف</a>--}}
                                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                            data-target="#deletemodal<?php echo $spent->id; ?>"><i class="fa fa-trash-o icon" style="padding-left: 2px;"></i> حذف
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="deletemodal<?php echo $spent->id; ?>"
                                                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-primary text-white" >
                                                                    <p class="modal-title" style="margin: 0 auto;" >پرداخت انتخاب شده حذف گردد؟</p>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>منبع اعتبار:     {{$spent->id}}    </p>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a href="{{url('/spents/deleteSpent/'.$spent->id)}}"
                                                                       class="btn btn-danger ">حذف</a>
                                                                    <button type="button" class="btn btn-primary"
                                                                            data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
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


                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                    data-target="#addspendmodal"><i class="fa fa-plus icon" style="padding-left: 2px;"></i> پرداخت جدید
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="addspendmodal" tabindex="-1" role="dialog" >
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-success text-white">
پرداخت جدید

                                        </div>
                                        <div class="modal-body">

                                                <form action="{{'/spents/addconspent/'.$contract->id}}" method="post" class="form-horizontal">
                                                    {{ csrf_field() }}

                                                    {{-- <input type="text" name="credit_code" class="form-control" id="credit_code" hidden="hidden"
                                                            value="{{   $contract->credit_id}}">--}}
                                                    <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                                                        <label for="give_date" class="col-sm-4 control-label">تاریخ پرداخت</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" name="give_date" class="form-control DatePicker" id="give_date_picker">

                                                            @if ($errors->has('give_date'))
                                                                <span class="help-block">
                                        <strong>{{ $errors->first('give_date') }}</strong>
                                    </span>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                        <label for="person" class="col-sm-4 control-label">مبلغ*</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="price" class="form-control" id="price"
                                                                   placeholder="لطفا مبلغ هزینه را وارد نمایید" value="{{ old('price') }}">

                                                            @if ($errors->has('price'))
                                                                <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                                            @endif

                                                        </div>
                                                    </div>
                           <div class="form-group{{ $errors->has('source_code') ? ' has-error' : '' }}">
                              <label for="source_code" class="col-sm-2 control-label">منبع اعتبار</label>
                              <div class="col-sm-10">
                                  <select name="source_code" class="form-control" id="source_code">
                                      <option value="">لطفا منبع اعتبار را انتخاب نمایید...</option>
                                      @foreach($vsubtassigns as $vsubtassign)
                                          <option value="{{$vsubtassign->id}}">{{$vsubtassign->source_name}} </option>
                                      @endforeach
                                  </select>

                                  @if ($errors->has('source_code'))
                                      <span class="help-block text-danger">
                                          <strong>{{ $errors->first('source_code') }}</strong>
                                      </span>
                                  @endif

                              </div>
                          </div>
                                                    <div class="form-group">
                                                        <label for="comments" class="col-sm-4 control-label">توضیحات</label>
                                                        <div class="col-sm-8">
                                                            <textarea type="text" name="comments" class="form-control" id="comments"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-8 col-md-offset-2">
                                                            <button type="submit" class="btn btn-primary">
                                                                پرداخت
                                                            </button>

                                                        </div>
                                                    </div>


                                                </form>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
                                            </button>
                                            <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--end modal--}}

                        </div>

                    </div>
                </div>





        </div>
    </div>
@endsection

