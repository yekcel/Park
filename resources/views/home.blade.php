@extends('layouts.app')
@section('style')
    <style>
        a.dashbord{
            height: 110px;
            vertical-align: center;
            horiz-align: center;
            width: 100%;
            margin-top: 10px;
            min-width: 150px;!important

        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center">
                    <img class="img-fluid" src="{{ asset('img/logo.png') }}" >
                    <hr>
                    <div><h4>سامانه مدیریت بودجه ریزی عملیاتی پارک علم و فناوری دانشگاه سمنان</h4></div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white " style="background: linear-gradient(90deg,#2583ee,#712f90); "><h5><i class="fa fa-dashboard  icon" style="padding-left: 3px;font-size: 150%"></i>  میز کار</h5></div>

                <div class="card-body" >

                    <div class="container-fluid bg-3 text-center">

                        <div class="row">
                            <div class="col-sm-3">
                                <a class="btn btn-outline-dark dashbord" href="{{url('/assigns')}}">
                                    <span><h4><i class="fa fa-calculator icon" style="padding-left: 3px;color: #298fe2;font-size: 250%"></i></h4></span> بودجه ریزی</a>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-outline-dark dashbord" href="{{url('/select_year')}}">
                                    <span><h4><i class="fa fa-cart-arrow-down icon" style="padding-left: 3px;color: #298fe2;font-size: 250%"></i></h4></span> هزینه</a>

                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-outline-dark dashbord" href="{{url('/reports')}}">
                                    <span><h4><i class="fa fa-file-text icon" style="padding-left: 3px;color: #298fe2;font-size: 250%"></i></h4></span> گزارش</a>

                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-outline-dark dashbord" href="{{url('/applications/3')}}">
                                    <span><h4><i class="fa fa-handshake-o  icon" style="padding-left: 3px;color: #298fe2;font-size: 250%"></i></h4></span> قرارداد ها</a>

                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <a class="btn btn-outline-dark dashbord" href="{{url('/companies')}}">
                                    <span><h4><i class="fa fa-building icon" style="padding-left: 3px;color: #298fe2;font-size: 250%"></i></h4></span> واحد های فناور</a>

                            </div>

                            @can('isAdmin')
                            <div class="col-sm-3">
                                <a class="btn btn-outline-dark dashbord" href="{{url('/users')}}">
                                    <span><h4><i class="fa fa-users  icon" style="padding-left: 3px;color: #298fe2;font-size: 250%"></i></h4></span> مدیریت کاربران</a>

                            </div>
                            @endcan


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
