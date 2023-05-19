@extends('layouts.app')

@section('title')
  ثبت هزینه جدید
@endsection
@section('style')
    <style>



    </style>
        @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12">
    <div class=" card bg-white">
        <div class="card-header bg-primary text-white" style="background: linear-gradient(90deg,#2583ee,#712f90); ">
           <div class="row">
               <div class="col-md-10"><i class="fa fa-plus icon" style="padding-left: 2px;"></i>ثبت هزینه جدید
                    </div>
            <div class="col-sm-2"><a href="{{url('/subactions/'.$subaction->id)}}" class="btn btn-dark btn-xs"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i>بازگشت</a>
            </div>
           </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                    <form action="{{'/spents/addspent/'.$subaction->id}}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('subactionname') ? ' has-error' : '' }}">
                            <label for="subactionname" class="control-label">ریزفعالیت</label>
                            <div class="col-md-6" >
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
                            <label for="costname" class="control-label">نوع هزینه</label>
                            <div class="col-md-6">
                                <input type="text" name="costname" class="form-control" id="costname" readonly="readonly"

                                       value="{{ $cost->name }}">

                                @if ($errors->has('costname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('costname') }}</strong>
                                    </span>
                                @endif

                            </div>
                            <input type="text" name="cost_id" class="form-control" id="cost_id" hidden="hidden" value="{{ $cost->id }}">
                        </div >
                        <div class="form-group{{ $errors->has('doc_number') ? ' has-error' : '' }}">
                            <label for="doc_number" class="control-label">شماره سند</label>
                            <div class="col-md-6">
                                <input type="text" name="doc_number" class="form-control" id="doc_number"
                                       placeholder="لطفا شماره سند را وارد نمایید"
                                       value="{{ $errors->has('spentname')?old('spentname'):Session::pull('doc_number')}}">
                                @if ($errors->has('doc_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('doc_number') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('spentname') ? ' has-error' : '' }}">
                            <label for="spentname" class="control-label">موضوع هزینه</label>
                            <div class="col-md-6">
                                <input type="text" name="spentname" class="form-control" id="spentname"
                                       placeholder="لطفا موضوع هزینه را وارد نمایید"
                                       value="{{ old('spentname') }}">
                                @if ($errors->has('spentname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('spentname') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="person" class="control-label">مبلغ*</label>
                            <div class="row col-md-6" >
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

                        <div class="form-group{{ $errors->has('give_date') ? ' has-error' : '' }}">
                            <label for="give_date" class="control-label">تاریخ هزینه</label>
                            <div class="col-md-6">
                                <input type="text" name="give_date" class="form-control" id="give_date_picker">

                                @if ($errors->has('give_date'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('give_date') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('source_code') ? ' has-error' : '' }}">
                            <label for="source_code" class="control-label">منبع اعتبار</label>
                            <div class="col-md-6">
                                <select name="source_code" class="form-control" id="source">
                                    <option value="">لطفا منبع اعتبار را انتخاب نمایید...</option>
                                    @foreach($vsubtassigns as $vsubtassign)
                                        <option value="{{$vsubtassign->id}}">{{$vsubtassign->source_name}} </option>
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
                            <label for="credit_code" class="control-label">نوع مصرف</label>
                            <div class="col-md-6">
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

                        @if($cost->id==34||$cost->id==42||$cost->id==41||$cost->id==52||$cost->id==53||
                        $cost->id==54||$cost->id==55||$cost->id==56||$cost->id==57||$cost->id==58||
                        $cost->id==59||$cost->id==60||$cost->id==62||$cost->id==63)
                            <div id="accordion" style="width: 100%;!important;">
                                واحد های فناور مربوطه
                                <div class="card" >
                                    <div class="card-header ">
                                        <a class="collapsed card-link " data-toggle="collapse" href="#collapseOne">
                                            <i class="fa fa-arrow-circle-o-down  icon" style="padding-left: 2px;"></i> انتخاب واحد های های فناور پیش رشد </a>
                                    </div>
                                    <div id="collapseOne" class="collapse " data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                            @foreach($companies as $company)
                                                @if($company->kind==1)
                                                    <div class="inputGroup">
                                                   <input type="checkbox" style="padding: 5px;" id="option" name="company[]" value="{{$company->id}}"> <label for="option">{{$company->name}}</label>
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
                                            <i class="fa fa-arrow-circle-o-down  icon" style="padding-left: 2px;"></i> انتخاب واحد های های فناور رشد </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($companies as $company)
                                                    @if($company->kind==2)
                                                        <div class="inputGroup">
                                                            <input type="checkbox" style="padding: 5px;" id="option" name="company[]" value="{{$company->id}}"> <label for="option">{{$company->name}}</label>
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
                                            <i class="fa fa-arrow-circle-o-down  icon" style="padding-left: 2px;"></i> انتخاب واحد های های فناور پارک </a>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($companies as $company)
                                                    @if($company->kind==3)
                                                        <div class="inputGroup">
                                                            <input type="checkbox" style="padding: 5px;" id="option" name="company[]" value="{{$company->id}}"> <label for="option">{{$company->name}}</label>
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
                                <textarea type="text" name="comments" class="form-control" id="comments"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-primary">
                                    ذخیره
                                </button>

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div> </div>
        </div>
    </div>
@endsection
@section('bottom_script')
    <script type="application/javascript">
        $(function() {
            $('#source').on('change', function (e) {

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

        });});
        /* $.ajax({
                   type: 'GET',
                   url: '/spents/' + source_code + '/bud',
                   success: function (data) {
                       if (!$.isEmptyObject(data)) {
                           //  console.log(data);
                           $('#bud').html(data);

                       }
                       else {
                           $('#bud').html('');
                       }
                   },
                   error: function (data) {
                       console.log(data);
                   }
               });*/
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
