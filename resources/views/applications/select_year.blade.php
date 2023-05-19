@extends('layouts.app')
@section('style')
    <style>
        body{
            margin: 0;
            padding: 0;
            /*font-family: sans-serif;*/
            color: #333;
            background-color: #eee;
        }

        h1, h2, h3, h4, h5, h6{
            font-weight: 200;
        }

        h1{
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #3490dc;
            max-width: 40%;
            margin: 20px auto;
        }

        /* CONTAINERS */

        .container {max-width: 850px; width: 100%; margin: 0 auto;}
        .four { width: 22%; max-width: 25.26%;}


        /* COLUMNS */

        .col {
            display: block;
            float:left;
            margin: 1% 0 1% 1.6%;
        }

        .col:first-of-type { margin-left: 0; }

        /* CLEARFIX */

        .cf:before,
        .cf:after {
            content: " ";
            display: table;
        }

        .cf:after {
            clear: both;
        }

        .cf {
            *zoom: 1;
        }

        /* FORM */

        .form .plan input, .form .payment-plan input, .form .payment-type input{
            display: none;
        }

        .form label{
            position: relative;
            color: #fff;
            background-color: #aaa;
            font-size: 26px;
            text-align: center;
            height: 150px;
            line-height: 150px;
            display: block;
            cursor: pointer;
            border: 3px solid transparent;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .form .plan input:checked + label, .form .payment-plan input:checked + label, .form .payment-type input:checked + label{
            border: 3px solid #333;
            background-color: #3490dc;
        }

        .form .plan input:checked + label:after, form .payment-plan input:checked + label:after, .form .payment-type input:checked + label:after{
            content: "\2713";
            width: 40px;
            height: 40px;
            line-height: 40px;
            border-radius: 100%;
            border: 2px solid #333;
            background-color: #3490dc;
            z-index: 999;
            position: absolute;
            top: -10px;
            right: -10px;
        }

        .submit{
            padding: 15px 60px;
            display: inline-block;
            border: none;
            margin: 20px 0;
            background-color: #3490dc;
            color: #fff;
            border: 2px solid #333;
            font-size: 18px;
            -webkit-transition: transform 0.3s ease-in-out;
            -o-transition: transform 0.3s ease-in-out;
            transition: transform 0.3s ease-in-out;
        }

        .submit:hover{
            cursor: pointer;
            transform: rotateX(360deg);
        }
    </style>
@endsection
@section('content')

    <div class="card bg-secondary text-white ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10"></div>
             {{--   <div class="col-sm-2"><a href="{{url('home')}}" class="btn btn-success btn-xs">بازگشت</a>--}}


                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="container">
                <h1>انتخاب سال مالی</h1>
                <form class="form cf" action="{{'/applications'}}" method="post">
                    {{ csrf_field() }}

                    <section class="payment-type cf">

                        <h2>سال مالی را انتخاب نمایید</h2>


                            @foreach($years as $year)
                                <input type="radio" name="radio3" id="credit{{$year->id}}" value="{{$year->name}}" @php if($year->name==$year1){echo 'checked';} @endphp><label class="credit-label four col" for="credit{{$year->id}}">{{$year->name}}</label>

                            @endforeach

                    </section>
                    <input class="submit" type="submit" value="Submit">
                </form>
            </div>



        </div>
    </div>
@endsection
