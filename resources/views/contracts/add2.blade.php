@extends('layouts.app')

@section('title')
     قرارداد شماره {{$contract->num}}
@endsection

@section('content')
    <div class=" card bg-white">
        <div class="card-header">
            <div class="row">
                <h4>ریزفعالیت :{{$contract->subaction->name}}</h4>

            </div>
            <div class="row">
                <h4>نوع هزینه :{{$contract->cost->name}}</h4>

            </div>

        </div>


        <div class="card-body">
            <p><span class="accent">شماره قرارداد: </span>{{$contract->num}}</p>
            <p><span class="accent">تاریخ انعقاد قرارداد: </span>{{$contract->date?Verta::instance($contract->date)->formatJalaliDate():null}}</p>
            @if($contract->tittle==1)
                <p><span class="accent">عنوان قرارداد: </span>قرارداد پشتیبانی</p>
            @elseif($contract->tittle==2)
                <p><span class="accent">عنوان قرارداد: </span>سیدمانی </p>
            @else
                <p><span class="accent">عنوان قرارداد: </span>کانون شکوفایی </p>
            @endif
            {{-- <p><span class="accent">عنوان قرارداد: </span>{{$contract->tittle}}</p>--}}
            <p><span class="accent">شرکت طرف قرارداد: </span>{{$contract->company->name}}</p>
            @if($contract->level==1)
                <p><span class="accent">مقطع پذیرش: </span>هسته دوره پیش رشد</p>
            @elseif($contract->level==2)
                <p><span class="accent">مقطع پذیرش: </span>فناور دوره رشد</p>
            @else
                <p><span class="accent">مقطع پذیرش: </span>فناور</p>
            @endif
            <p><span class="accent">تاریخ شروع قرارداد: </span>{{$contract->date?Verta::instance($contract->date)->formatJalaliDate():null}}</p>
            <p><span class="accent">مدت قرارداد: </span>{{$contract->duration}}</p>
            <p><span class="accent">مبلغ اعتبار مصوب قرارداد: </span>{{$contract->totalcredit}}</p>
            <p><span class="accent">مدت قرارداد: </span>{{$contract->duration}}</p>
            <p><span class="accent">توضیحات: </span>{{$contract->comments}}</p>
            <p><span class="accent">اعتبارات تخصیص یافته: </span></p>
            <div class="col-md-6 ">
                <table class="table table-striped table-hover" >
                    <thead>
                    <tr>
                        <th class="text-center" >سال</th>
                        <th class="text-center">مبلغ</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($contract->conassign as $conassign)
                        <tr>
                            <td>{{$conassign->year}}</td>
                            <td>{{$conassign->price?$conassign->price:null}}</td>

                        </tr>
                    @endforeach
                    <tr>
                        <td>------</td>
                        <td>------</td>
                    </tr>
                    <tr>
                        <td>مجموع اعتبارات تخصیص یافته</td>
                        <td>{{$contract->conassign?$contract->conassign->sum('price'):0}}</td>

                    </tr>
                    <tr>
                        <td>باقی مانده(بدون تخصیص اعتبار)</td>
                        <td>{{$contract->totalcredit-$contract->conassign->sum('price')}}</td>

                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-header">تخصیص اعتبار</h3>
                </div>
                <div class="card-body">
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
                                <button type="submit" class="btn btn-primary">
                                   ثبت
                                </button>

                            </div>
                        </div>


                    </form>
                </div>

            </div>
            <div class="col-md-8 col-md-offset-2">
@if($contract->totalcredit-$contract->conassign->sum('price')==0)
                <a class="btn btn-success"  href="{{url('/subactions/'.$contract->subaction_id)}}">
                   بازگشت
                </a>
    @else
                    <button class="btn btn-danger"  href="{{url('/subactions/'.$contract->subaction_id)}}" disabled>
                        بازگشت
                    </button>
                @endif
            </div>
        </div>
    </div>
@endsection
