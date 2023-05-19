@extends('layouts.app')

@section('title')
    ثبت اعتبار جدید
@endsection

@section('content')

    <div class=" card bg-white">
        <div class="card-header">ثبت اعتبار جدید
            <div class="row">
                <h4>ریزفعالیت :{{$subaction->name}}</h4>
                <h4>نوع هزینه :{{$cost->name}}({{$cost->cost_code}})</h4>

            </div>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <form action="{{'/contracts/addcontract'}}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('subactionname') ? ' has-error' : '' }}">
                            <label for="subactionname" class="col-sm-4 control-label">ریزفعالیت</label>
                            <div class="col-sm-8">
                                <input type="text" name="subactionname" class="form-control" id="subactionname" readonly="readonly"

                                       value="{{ $subaction->name }}">

                                @if ($errors->has('subactionname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subactionname') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <input type="text" name="subaction_id" class="form-control" id="subaction_id" hidden="hidden" value="{{ $subaction->id }}">
                        </div>

                        <div class="form-group{{ $errors->has('costname') ? ' has-error' : '' }}">
                            <label for="costname" class="col-sm-4 control-label">نوع هزینه</label>
                            <div class="col-sm-8">
                                <input type="text" name="costname" class="form-control" id="costname" readonly="readonly"

                                       value="{{ $cost->name }}">

                                @if ($errors->has('costname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('costname') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <input type="text" name="cost_id" class="form-control" id="cost_id" hidden="hidden" value="{{ $cost->id }}">
                        </div>

                        <div class="form-group{{ $errors->has('num') ? ' has-error' : '' }}">
                            <label for="num" class="col-sm-4 control-label">شماره قرارداد*</label>
                            <div class="col-sm-8">
                                <input type="text" name="num" class="form-control" id="num"
                                       placeholder="لطفاشماره قرارداد را وارد نمایید" value="{{ old('num') }}">ریال

                                @if ($errors->has('num'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('num') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class="col-sm-2 control-label">شرکت طرف قرارداد</label>
                            <div class="col-sm-10">
                                <select name="company" class="form-control" id="company">
                                    <option value="">لطفا شرکت طرف قرارداد را انتخاب نمایید...</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('company'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                            <label for="give_date" class="col-sm-4 control-label">تاریخ انعقاد</label>
                            <div class="col-sm-6">
                                <input type="text" name="give_date" class="form-control" id="give_date_picker">

                                @if ($errors->has('give_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('give_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tittle') ? ' has-error' : '' }}">
                            <label for="tittle" class="col-sm-4 control-label">عنوان قرارداد*</label>
                            <div class="col-sm-8">
                                <select name="tittle" class="form-control" id="tittle">
                                    <option value=""   @if(old('tittle')==NULL) selected @endif>لطفا موضوع قراداد را انتخاب نمایید...</option>
                                    <option value="1"  @if(old('tittle')==1) selected @endif>قرارداد پشتیبانی</option>
                                    <option value="2"  @if(old('tittle')==2) selected @endif>سیدمانی</option>
                                    <option value="2"  @if(old('tittle')==3) selected @endif>کانون شکوفایی</option>
                                </select>

                                @if ($errors->has('tittle'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tittle') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="text" name="subaction_id" class="form-control" id="subaction_id" hidden="hidden" value="{{ $subaction->id }}">
                        </div>

                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label for="start_date" class="col-sm-4 control-label">تاریخ شروع</label>
                            <div class="col-sm-6">
                                <input type="text" name="start_date" class="form-control" id="start_date_picker">

                                @if ($errors->has('start_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="col-sm-4 control-label">مقطع پذیرش</label>
                            <div class="col-sm-8">
                                <select name="level" class="form-control" id="level">
                                    <option value=""   @if(old('level')==NULL) selected @endif>لطفا مقطع پذیرش را انتخاب نمایید...</option>
                                    <option value="1"  @if(old('level')==1) selected @endif>هسته دوره پیش رشد</option>
                                    <option value="2"  @if(old('level')==2) selected @endif>فناور دوره رشد</option>
                                    <option value="2"  @if(old('level')==3) selected @endif>فناور</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
                            <label for="duration" class="col-sm-4 control-label">مدت قرارداد</label>
                            <div class="col-sm-8">
                                <input type="text" name="duration" class="form-control" id="duration"
                                       placeholder="لطفا مدت قرارداد را وارد نمایید"
                                       value="{{ old('duration') }}">
                                @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="person" class="col-sm-4 control-label">مبلغ اعتبار مصوب*</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="لطفا مبلغ اعتبار مصوب را وارد نمایید" value="{{ old('price') }}">ریال

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
                        <div class="form-group{{ $errors->has('credit_code') ? ' has-error' : '' }}">
                            <label for="credit_code" class="col-sm-2 control-label">نوع مصرف</label>
                            <div class="col-sm-10">
                                <select name="credit_code" id="credits" class="form-control">
                                            <option value="">...</option>
                                </select>

                                @if ($errors->has('credit_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('credit_code') }}</strong>
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
@section('bottom_script')
    <script type="application/javascript">
        window.onload = function () {
            $('#source').on('change', function (e) {
                console.log(e);

                var source_code = e.target.value;
                $.ajax({
                    type: 'GET',
                    url: '/spents/' + source_code + '/credit',
                    success: function (data) {
                        if (!$.isEmptyObject(data)) {
                            //  console.log(data);
                            $('#credits').html(data);
                        }
                        else {
                            $('#credits').html('');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });}

    </script>
@endsection
