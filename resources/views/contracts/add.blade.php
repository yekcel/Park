@extends('layouts.app')

@section('title')
    ثبت قرارداد جدید
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12">
    <div class=" card bg-white">
        <div class="card-header bg-primary text-white">
            <div class="row">

                <div class="col-md-9"><h5 > ثبت قرارداد جدید <span style="color: #2fcc71" ><b> > </b></span>مقطع پذیرش : {{$level}} </h5></div>
                <div class="col-sm-3"><a href="{{url('/subactions/'.$subaction->id)}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
            </div>
</div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <form action="{{'/contracts/addcontract'}}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('subactionname') ? ' has-error' : '' }}">
                            <label for="subactionname" class=" control-label">ریزفعالیت</label>
                            <div >
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
                            <label for="costname" class=" control-label">نوع هزینه</label>
                            <div>
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
                            <label for="num" class=" control-label">شماره قرارداد*</label>
                            <div >
                                <input type="text" name="num" class="form-control" id="num"
                                       placeholder="لطفاشماره قرارداد را وارد نمایید" value="{{ old('num') }}">

                                @if ($errors->has('num'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('num') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                            <label for="company" class=" control-label">واحد فناور طرف قرارداد</label>
                            <div >
                                <select name="company" class="form-control" id="company">
                                    <option value="">لطفا واحد فناور طرف قرارداد را انتخاب نمایید...</option>
                                    @foreach($companies as $company)
                                        <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                </select>

                                @if ($errors->has('company'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                            <label for="give_date" class=" control-label">تاریخ انعقاد</label>
                            <div >
                                <input type="text" name="give_date" class="form-control" id="give_date_picker">

                                @if ($errors->has('give_date'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('give_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('tittle') ? ' has-error' : '' }}">
                            <label for="tittle" class="control-label">عنوان قرارداد*</label>
                            <div >
                                <select name="tittle" class="form-control" id="tittle">
                                    <option value=""   @if(old('tittle')==NULL) selected @endif>لطفا موضوع قراداد را انتخاب نمایید...</option>
                                    <option value="1"  @if(old('tittle')==1) selected @endif>قرارداد پشتیبانی</option>
                                    @if($subaction->action->id==10)
                                    <option value="2"  @if(old('tittle')==2) selected @endif>سیدمانی</option>
                                    @endif
                                    @if($subaction->action->id==9)
                                    <option value="3"  @if(old('tittle')==3) selected @endif>کانون شکوفایی</option>
                                    <option value="4"  @if(old('tittle')==4) selected @endif>هسته دانشگاهی</option>
                                    @endif
                                    <option value="5"  @if(old('tittle')==5) selected @endif>تجاری سازی</option>
                                </select>

                                @if ($errors->has('tittle'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('tittle') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="text" name="subaction_id" class="form-control" id="subaction_id" hidden="hidden" value="{{ $subaction->id }}">
                        </div>

                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                            <label for="start_date" class="control-label">تاریخ شروع</label>
                            <div >
                                <input type="text" name="start_date" class="form-control" id="start_date_picker">

                                @if ($errors->has('start_date'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>





                        <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
                            <label for="duration" class=" control-label">مدت قرارداد</label>
                            <div >
                                <input type="text" name="duration" class="form-control" id="duration"
                                       placeholder="لطفا مدت قرارداد را وارد نمایید"
                                       value="{{ old('duration') }}">
                                @if ($errors->has('duration'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class=" control-label">مبلغ اعتبار مصوب*</label>
                            <div class="row" >
                                <div class="col-md-10">
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="لطفا مبلغ اعتبار مصوب را وارد نمایید" value="{{ old('price') }}">
                                </div>
                                <div class="col-md-2 ">ریال</div>
                            </div>

                                @if ($errors->has('price'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif

                            </div>



                        <div class="form-group{{ $errors->has('paid_befor') ? ' has-error' : '' }}">
                            <label for="paid_befor" class="control-label">مبلغ پرداخت شده از سال های قبل (قبل از ثبت قرارداد)</label>
                            <div class="row" >
                                <div class="col-md-10">
                                <input type="text" name="paid_befor" class="form-control" id="paid_befor"
                                       placeholder="لطفا مبلغ پرداخت شده از سال های قبل را وارد نمایید" value="{{ old('paid_befor') }}">
                                </div>
                                <div class="col-md-2 ">ریال</div>
                            </div>
                                @if ($errors->has('paid_befor'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('paid_befor') }}</strong>
                                    </span>
                                @endif

                            </div>


                        <div class="form-group">
                            <label for="comments" class=" control-label">توضیحات</label>
                            <div >
                                <textarea type="text" name="comments" class="form-control" id="comments"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save icon" style="padding-left: 2px;"></i>
                                    ثبت قرارداد
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--@section('bottom_script')
    <script type="application/javascript">
        $(function() {
            $('#source_code').on('change', function (e) {

                var source_code = $(this).val();
                //    alert(source_code);
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

            });

        });

    </script>
@endsection--}}
