@extends('layouts.app')

@section('title')
    ویرایش هزینه
@endsection

@section('content')

    <div class=" card bg-white">
        <div class="card-header">ویرایش هزینه
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <h4>ریزفعالیت :{{$spent->subaction->name}}</h4>
                    </div>
                    <div class="row">
                        <h4 >نوع هزینه :{{$spent->cost->name}}({{$spent->cost->cost_code}})</h4>
                    </div>
                </div>
                <div class="col-sm-2"><a href="{{url('/subactions/'.$spent->subaction_id)}}" class="btn btn-dark btn-xs">بازگشت</a>
                </div>
            </div>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <form action="{{'/spents/edit/'.$spent->id}}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        {{method_field('PATCH')}}
                        <div class="form-group{{ $errors->has('subactionname') ? ' has-error' : '' }}">
                            <label for="subactionname" class="col-sm-4 control-label">ریزفعالیت</label>
                            <div class="col-sm-8">
                                <input type="text" name="subactionname" class="form-control" id="subactionname" readonly="readonly"

                                       value="{{ $spent->subaction->name }}">

                                @if ($errors->has('subactionname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subactionname') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <input type="text" name="subaction_id" class="form-control" id="subaction_id" hidden="hidden" value="{{ $spent->subaction->id }}">
                        </div>

                        <div class="form-group{{ $errors->has('costname') ? ' has-error' : '' }}">
                            <label for="costname" class="col-sm-4 control-label">نوع هزینه</label>
                            <div class="col-sm-8">
                                <input type="text" name="costname" class="form-control" id="costname" readonly="readonly"

                                       value="{{ $spent->cost->name }}">

                                @if ($errors->has('costname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('costname') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <input type="text" name="cost_id" class="form-control" id="cost_id" hidden="hidden" value="{{ $spent->cost->id }}">
                        </div>
                        <div class="form-group{{ $errors->has('doc_number') ? ' has-error' : '' }}">
                            <label for="doc_number" class="col-sm-4 control-label">شماره سند</label>
                            <div class="col-sm-8">
                                <input type="text" name="doc_number" class="form-control" id="doc_number"
                                       placeholder="لطفا شماره سند را وارد نمایید"
                                       value="{{ $errors->has('doc_number')?old('doc_number'):$spent->doc_number }}">
                                @if ($errors->has('doc_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('doc_number') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('spentname') ? ' has-error' : '' }}">
                            <label for="worktime" class="col-sm-4 control-label">موضوع هزینه</label>
                            <div class="col-sm-8">
                                <input type="text" name="spentname" class="form-control" id="spentname"
                                       placeholder="لطفا موضوع هزینه را وارد نمایید"
                                       value="{{ $errors->has('spentname')?old('spentname'):$spent->name }}">
                                @if ($errors->has('spentname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('spentname') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="person" class="col-sm-4 control-label">مبلغ*</label>
                            <div class="col-sm-8">
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="لطفا مبلغ هزینه را وارد نمایید"
                                value="{{ $errors->has('price')?old('price'):$spent->price }}">
                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                            <label for="give_date" class="col-sm-4 control-label">تاریخ هزینه</label>
                            <div class="col-sm-6">
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
                            <label for="source_code" class="col-sm-2 control-label">منبع اعتبار</label>
                            <div class="col-sm-10">
                                <select name="source_code" class="form-control" id="source">
                                    <option value="">لطفا منبع اعتبار را انتخاب نمایید...</option>
                                    @foreach($vsubtassigns as $vsubtassign)
                                        <option value="{{$vsubtassign->id}}" @if ($vsubtassign->id == $spent->subassign_id) selected="selected" @endif>{{$vsubtassign->source_name}} </option>
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
                                    <option value="">لطفا نوع مصرف را انتخاب نمایید...</option>

                                </select>

                                @if ($errors->has('credit_code'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('credit_code') }}</strong>
                                    </span>
                                @endif

                            </div>

                        </div>
                        @if($spent->cost_id==34||$spent->cost_id==42||$spent->cost_id==41||$spent->cost_id==52||$spent->cost_id==53||
                        $spent->cost_id==54||$spent->cost_id==55||$spent->cost_id==56||$spent->cost_id==57||$spent->cost_id==58||
                        $spent->cost_id==59||$spent->cost_id==60||$spent->cost_id==62||$spent->cost_id==63)
                            <div id="accordion">
                                شرکت های مربوطه*
                                <div class="card">
                                    <div class="card-header">
                                        <a class="card-link btn-primary" data-toggle="collapse" href="#collapseOne">
                                            انتخاب شرکت های پیش رشد
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse " data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($companies as $company)
                                                    @if($company->kind==1)
                                                        <div class="inputGroup">
                                                            <input type="checkbox" style="padding: 5px;" id="option" name="company[]" value="{{$company->id}}" @foreach($spent->company as $spentcompany)
                                                            @if ($spentcompany->id == $company->id)
                                                            checked="checked"
                                                                @endif
                                                                @endforeach> <label for="option">{{$company->name}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                            انتخاب شرکت های رشد
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($companies as $company)
                                                    @if($company->kind==2)
                                                        <div class="inputGroup">
                                                            <input type="checkbox" style="padding: 5px;" id="option" name="company[]" value="{{$company->id}}" @foreach($spent->company as $spentcompany)
                                                            @if ($spentcompany->id == $company->id)
                                                            checked="checked"
                                                                @endif
                                                                @endforeach> <label for="option">{{$company->name}}</label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
                                            انتخاب شرکت های پارک
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($companies as $company)
                                                    @if($company->kind==3)
                                                        <div class="inputGroup">

                                                            <input type="checkbox" style="padding: 5px;" id="option" name="company[]" value="{{$company->id}}" @foreach($spent->company as $spentcompany)
                                                            @if ($spentcompany->id == $company->id)
                                                            checked="checked"
                                                                @endif
                                                                @endforeach> <label for="option">{{$company->name}}</label>

                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                        <div class="form-group">
                            <label for="comments" class="col-sm-4 control-label">توضیحات</label>
                            <div class="col-sm-8">
                                <textarea type="text" name="comments" class="form-control" id="comments">@php  if($spent->comments!=null){echo $spent->comments;}  @endphp</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    ذخیره
                                </button>
                                <a class="btn btn-danger"  href="{{url('/subactions/'.$spent->subaction_id)}}">
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
        /* .get('/spents/ajaxGetCredits?col_id=' + source_code, function (data) {
         console.log('hi');
         $('#credits').empty();

         $('#credits').append('<option value="" selected>لطفا نوع مصرف اعتبار را انتخاب نمایید ...</option>');
         $.each(data, function (index, grpObj) {
         $('#credits').append('<option value="' + grpObj.credit_code + '">' + grpObj.name + '</option>')
         })
         });*/
        //});
    </script>
@endsection
