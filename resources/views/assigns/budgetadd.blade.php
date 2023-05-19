@extends('layouts.app')

@section('title')
    اختصاص بودجه جدید
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-12">


    <div class=" card bg-white">
        <div class="card-header bg-success text-white"><i class="fa fa-plus icon" style="padding-left: 2px;"></i> تصویب بودجه جدید
            <div class="row">
                {{--<h4>ریزفعالیت :{{$subaction->name}}</h4>
                <h4>نوع هزینه :{{$cost->name}}({{$cost->cost_code}})</h4>--}}

            </div>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <form action="{{'/assigns/addtobud'}}" method="post" class="form-horizontal">
                        {{ csrf_field() }}


                        <div class="form-group{{ $errors->has('source_code') ? ' has-error' : '' }}">
                            <label for="source_code" class="col-sm-4 control-label">منبع اعتبار</label>
                            <div class="col-sm-10">
                                <select name="source_code" class="form-control" id="source">
                                    <option value="">لطفا منبع اعتبار را انتخاب نمایید...</option>
                                    @foreach($sources as $source)
                                        <option value="{{$source->code}}">{{$source->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('source_code'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('source_code') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('sup') ? ' has-error' : '' }}">
                            <label for="sup" class="col-sm-4 control-label">تامین کننده اعتبار</label>
                            <div class="col-sm-8">
                                <select name="sup" class="form-control" id="sup">
                                    <option value="" >لطفا تامین کننده اعتبار را انتخاب نمایید...</option>
                                    <option value="1" >سازمان برنامه و بودجه</option>
                                    <option value="2" >انتقالی</option>
                                    <option value="3" >سایر</option>
                                </select>
                            </div>
                            @if ($errors->has('sup'))
                                <span class="help-block text-danger">
                                        <strong>{{ $errors->first('sup') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('approved_price') ? ' has-error' : '' }}">
                            <label for="approved_price" class="col-sm-4 control-label">مبلغ مصوب*</label>
                            <div class="col-sm-8">
                                <input type="text" name="approved_price" class="form-control numberformat" id="approved_price"
                                       placeholder="لطفا مبلغ مصوب بودجه را وارد نمایید" value="{{ old('approved_price') }}">ریال

                                @if ($errors->has('approved_price'))
                                    <span class="help-blocktext-danger">
                                        <strong>{{ $errors->first('approved_price') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                     {{--   <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-sm-4 control-label">مبلغ اختصاص یافته اولیه</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="لطفا مبلغ بودجه را وارد نمایید" value="{{ old('price') }}">ریال

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>--}}
                        <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                            <label for="give_date" class="col-sm-4 control-label">تاریخ تصویب</label>
                            <div class="col-sm-6">
                                <input type="text" name="give_date" class="form-control" id="give_date_picker">

                                @if ($errors->has('give_date'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('give_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            <label for="year" class="col-sm-4 control-label">سال بودجه </label>
                            <div class="col-sm-10">
                                <select name="year" class="form-control" id="year">
                                    <option value="">لطفا سال مصرف را انتخاب نمایید...</option>
                                    @foreach($yearts as $year)
                                        <option value="{{$year->name}}">{{$year->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('year'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('year') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>


                        <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">توضیحات</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="comments" class="form-control" id="comments" placeholder="{{ old('comments') }}" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save icon" style="padding-left: 2px;"></i>
                                    ثبت
                                </button>
                                <a class="btn btn-danger"  href="{{url('/assigns')}}"><i class="fa fa-rotate-right icon" style="padding-left: 2px;"></i>
                                    بازگشت
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>
@endsection
