@extends('layouts.app')

@section('title')
    ویرایش کاربر
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12">


                <div class=" card bg-white">
                    <div class="card-header bg-primary text-white"><i class="fa fa-edit icon" style="padding-left: 2px;"></i>ویرایش کاربر
                        <div class="row">
                            {{--<h4>ریزفعالیت :{{$subaction->name}}</h4>
                            <h4>نوع هزینه :{{$cost->name}}({{$cost->cost_code}})</h4>--}}

                        </div>

                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2">
                                <form action="{{'/users/EditUser/'.$user->id}}" method="post" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{method_field('PATCH')}}
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{  $errors->has('name')?old('name'):$user->name }}" required autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row{{ $errors->has('level') ? ' has-error' : '' }}">
                                        <label for="level" class="col-sm-4 col-form-label text-md-right">Access Level</label>
                                        <div class="col-sm-6">
                                            <select name="level" class="form-control" id="level">
                                                <option value="" >Select Access Level</option>
                                                <option value="0" @if ($user->level == 0) selected="selected" @endif>Full Access</option>
                                                <option value="1" @if ($user->level == 1) selected="selected" @endif>Report Only</option>
                                                <option value="2" @if ($user->level == 2) selected="selected" @endif >Company</option>

                                            </select>
                                        </div>
                                        @if ($errors->has('level'))
                                            <span class="help-block text-danger">
                                        <strong>{{ $errors->first('level') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $errors->has('email')?old('email'):$user->email }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Save Change') }}
                                            </button>
                                            <a class="btn btn-danger"  href="{{url('/users')}}"><i class="fa fa-rotate-right icon" style="padding-left: 2px;"></i>
                                                Return
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
