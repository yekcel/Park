@extends('layouts.app')

@section('title')
    واحد فناور جدید
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12">


                <div class=" card bg-white">
                    <div class="card-header bg-primary text-white"><i class="fa fa-plus icon" style="padding-left: 2px;"></i>تعریف واحد فناور جدید
            <div class="row">
                {{--<h4>ریزفعالیت :{{$subaction->name}}</h4>
                <h4>نوع هزینه :{{$cost->name}}({{$cost->cost_code}})</h4>--}}

            </div>

        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <form action="{{'/companies/addCompany'}}" method="post" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('nameip') ? ' has-error' : '' }}">
                            <label for="nameip" class="col-sm-4 control-label">نام واحد فناور*</label>
                            <div class="col-sm-8">
                                <input type="text" name="nameip" class="form-control" id="nameip"
                                       placeholder="لطفا نام واحد فناور را وارد نمایید" value="{{ old('nameip') }}">
                           </div>
                        </div>
                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="col-sm-4 control-label">سطح واحد</label>
                            <div class="col-sm-8">
                                <select name="level" class="form-control" id="level">
                                    <option value="" >لطفا سطح واحد را انتخاب نمایید...</option>
                                    <option value="0" >بدون سطح</option>
                                    <option value="1" >پیش رشد</option>
                                    <option value="2" >رشد</option>
                                    <option value="3" >فناور</option>
                                </select>
                            </div>
                            @if ($errors->has('level'))
                                <span class="help-block text-danger">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('bossip') ? ' has-error' : '' }}">
                            <label for="bossip" class="col-sm-4 control-label">مدیر واحد*</label>
                            <div class="col-sm-8">
                                <input type="text" name="bossip" class="form-control" id="bossip"
                                       placeholder="لطفا نام مدیر واحد فناور را وارد نمایید" value="{{ old('bossip') }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phoneip') ? ' has-error' : '' }}">
                            <label for="phoneip" class="col-sm-4 control-label">شماره تلفن*</label>
                            <div class="col-sm-8">
                                <input type="text" name="phoneip" class="form-control" id="phoneip"
                                       placeholder="لطفا شماره تلفن واحد فناور را وارد نمایید" value="{{ old('phoneip') }}">
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('accip') ? ' has-error' : '' }}">
                            <label for="accip" class="col-sm-4 control-label">شماره حساب*</label>
                            <div class="col-sm-8">
                                <input type="text" name="accip" class="form-control" id="accip"
                                       placeholder="لطفا شماره حساب واحد فناور را وارد نمایید" value="{{ old('accip') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save icon" style="padding-left: 2px;"></i>
                                    ثبت
                                </button>
                                <a class="btn btn-danger"  href="{{url('/companies')}}"><i class="fa fa-rotate-right icon" style="padding-left: 2px;"></i>
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
