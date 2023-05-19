@extends('layouts.app')

@section('title')
    لیست گزارشات
@endsection

@section('content')

    <div class="card ">
        <div class="card-header text-white" style="background: linear-gradient(90deg,#2583ee,#712f90); ">
            <div class="row">
                <div class="col-sm-10"><h4><i class="fa fa-file-text icon" style="padding-left: 2px;font-size: 150%"></i> لیست گزارشات</h4></div>
                {{--<div class="col-sm-2"><a href="{{url('needs/add')}}" class="btn btn-success btn-xs">درخواست جدید</a>
                    <a href="{{url('needs/export')}}" class="btn btn-default btn-xs"><img
                            src="{{asset('img/xlsx-file-format-extension.png')}}">خروجی </a>

                </div>--}}
            </div>
        </div>

        <div class="card-body">
            <div class="card text-white  text-center" style="background-color:#798696;margin-bottom: 5px">
                <div class="card-header" > <h5>گزارش های وزارتخانه</h5></div>
                <div class="card-body">
                    <div class="row ">
                    <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/subbudget')}}">
                            <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-calculator icon" style="padding-left: 2px;"></i></p></span> گزارش بودجه و اعتبار ریزفعالیت ها</a></div>
                    <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/subcredit')}}">
                             <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-cart-arrow-down icon" style="padding-left: 2px;"></i></p></span> گزارش هزینه ریزفعالیت ها</a></div>
                    <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/pishreport')}}">
                             <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-spinner icon" style="padding-left: 2px;"></i></p></span>گزارش عملکرد واحد های پیش رشد</a></div>
                    <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/roshdreport')}}">
                             <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-gear icon" style="padding-left: 2px;"></i></p></span> گزارش عملکرد واحد های رشد</a></div>
                    <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/fanreport')}}">
                             <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-gears icon" style="padding-left: 2px;"></i></p></span> گزارش عملکرد واحد های فناور پارک</a></div>
                    </div>
                </div>
            </div>

            <div class="card text-white  text-center" style="background-color:#2583ee">
                <div class="card-header" > <h5>گزارش های کاربردی</h5></div>
                <div class="card-body">
                    <div class="row ">
                        <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/spent_subaction')}}">
                                <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-th icon" style="padding-left: 2px;"></i></p></span> گزارش عملکرد به تفکیک ریزفعالیت و موضوع هزینه</a></div>
                        <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/spent_company')}}">
                                <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-building icon" style="padding-left: 2px;"></i></p></span> گزارش عملکرد واحد های فناور</a></div>
                        <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/Apps')}}">
                                <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-codepen  icon" style="padding-left: 2px;"></i></p></span>گزارش هزینه و درآمد برنامه ها</a></div>
                        <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/Acts')}}">
                                <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-codepen  icon" style="padding-left: 2px;"></i></p></span> گزارش هزینه و درآمد فعالیت ها</a></div>
                        <div class="col  ui-state-default" style="min-width: 200px; height:180px;margin-bottom:  5px;margin-left:5px"><a style="height: 100%;width: 100%" class="btn btn-outline-light " href="{{url('/reports/SubActs')}}">
                                <span ><p style="width: 100%;font-size:400%; "><i class="fa fa-codepen  icon" style="padding-left: 2px;"></i></p></span> گزارش هزینه و درآمد ریزفعالیت ها</a></div>
                    </div>
                </div>
            </div>
            {{--<div class="row">

                <div class="card bg-dark text-white" style="width: 20%;margin-left: 10px">
                    <div class="card-header"> جداول </div>
                    <div class="card-body">
                        <div><a style="width: 100%" class="btn btn-primary " href="{{url('/reports/Persons')}}">جدول1 - هزینه های پرسنلی</a></div>

                        <div><a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/Supports')}}">جدول 2 - هزینه های پشتیبانی</a></div>
                        <div><a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/Research')}}">جدول 3 - اعتبارات مربوط به برنامه پژوهش و راهبری علم و فناوری </a></div>
                        <div><a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/Commercialization')}}">جدول 4 - اعتبارات مربوط به برنامه تجاری سازی یافته های پژوهشی </a></div>
                        <div><a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/FSPish')}}">جدول 5 - هزینه های حمایت مالی از واحد های پیش رشد </a></div>
                        <div><a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/FSPish')}}">جدول 6- هزینه های حمایت مالی از واحد های رشد </a></div>
                        <div><a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/FSPish')}}">جدول 7- هزینه های حمایت مالی از واحد های فناور </a></div>
                        <div><a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/FSPish')}}">جدول 5 - هزینه های پروزه ها و ماموریت های خاص </a></div>
                    </div>
                </div>
                <div class="card bg-dark text-white" style="width: 20%">
                    <div class="card-header"> گزارش عملکرد </div>
                    <div class="card-body">

                        <a style="width: 100%;margin-bottom: 2px" class="btn btn-success " href="{{url('/reports/spent_subaction')}}">گزارش عملکرد هزینه ای به
                            تفکیک ریزفعالیت و موضوع هزینه</a>
                        <a style="width: 100%;margin-bottom: 2px"class="btn btn-info " href="{{url('/reports/fanavarPish')}}">جدول 5- گزارش عملکرد سه ماهه واحد های  پیش رشد</a>
                        <a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/Roshd')}}">جدول 6- گزارش عملکرد سه ماهه واحد های رشد</a>
                        <a style="width: 100%;margin-bottom: 2px" class="btn btn-info " href="{{url('/reports/Fanavar')}}">جدول 7- گزارش عملکرد سه ماهه واحد های فناور</a>
                    </div>
                </div>
            </div>--}}
        </div>
    </div>

@endsection
