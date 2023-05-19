@extends('layouts.app')

@section('title')
    اختصاص اعتبار جدید
@endsection

@section('content')

    <div class=" card bg-white">
        <div class="card-header">اختصاص اعتبار جدید به برنامه ها
            <div class="row">
                {{--<h4>ریزفعالیت :{{$subaction->name}}</h4>
                <h4>نوع هزینه :{{$cost->name}}({{$cost->cost_code}})</h4>--}}

            </div>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <form action="{{'/assigns/addtoapp'}}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('application') ? ' has-error' : '' }}">
                            <label for="application" class="col-sm-2 control-label">برنامه</label>
                            <div class="col-sm-10">
                                <select name="application" class="form-control" id="application">
                                    <option value="">لطفا برنامه را انتخاب نمایید...</option>
                                    @foreach($applications as $application)
                                        <option value="{{$application->id}}">{{$application->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('application'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('application') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('source_code') ? ' has-error' : '' }}">
                            <label for="source_code" class="col-sm-2 control-label">منبع اعتبار</label>
                            <div class="col-sm-10">
                                <select name="source_code" class="form-control" id="source">
                                    <option value="">لطفا منبع اعتبار را انتخاب نمایید...</option>
                                    @foreach($sources as $source)
                                        <option value="{{$source->code}}">{{$source->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('source_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('source_code') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="person" class="col-sm-4 control-label">مبلغ اعتبار*</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="لطفا مبلغ اعتبار را وارد نمایید" value="{{ old('price') }}">ریال

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                            <label for="give_date" class="col-sm-4 control-label">تاریخ تصویب</label>
                            <div class="col-sm-6">
                                <input type="text" name="give_date" class="form-control" id="give_date_picker">

                                @if ($errors->has('give_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('give_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            <label for="year" class="col-sm-2 control-label">سال مصرف </label>
                            <div class="col-sm-10">
                                <select name="year" class="form-control" id="year">
                                    <option value="">لطفا سال مصرف را انتخاب نمایید...</option>
                                    @foreach($yearts as $year)
                                        <option value="{{$year->name}}">{{$year->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('year'))
                                    <span class="help-block">
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
                                <button type="submit" class="btn btn-primary">
                                    ذخیره
                                </button>
                                <a class="btn btn-danger"  href="{{url('/subactions/'.$subaction->id)}}">
                                    بازگشت
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
