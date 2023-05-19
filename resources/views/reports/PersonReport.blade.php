@extends('layouts.app')

@section('title')
    هزینه های پرسنلی
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="text-center">نوع استخدام</th>
                <th class="text-center">موضوع</th>
                <th class="text-center">تعداد متوسط نیرو در سال 96</th>
                <th class="text-center">عملکرد 96</th>
                <th class="text-center">تعداد متوسط نیرو در سال 97</th>
                <th class="text-center">مصوب 97</th>
                <th class="text-center">تعداد متوسط نیرو در نه ماهه 97</th>
                <th class="text-center">عملکرد نه ماهه 97</th>
                <th class="text-center">ضریب افزایش</th>
                <th class="text-center">پیش بینی اولیه 98</th>
                <th class="text-center">افزایش/کاهش تعداد</th>
                <th class="text-center">پیش بینی کاهش هزینه ناشی از بازنشستگی و ..</th>
                <th class="text-center">پیش  بینی ناشی از استخدام جدید</th>
                <th class="text-center">تعداد متوسط نیرو در سال98</th>
                <th class="text-center">هزینه واحد سال 98</th>
            </tr>
            </thead>
            <tbody>


            @php
                $subaction=$subactions->find(32);
              @endphp
            @foreach($subaction->costs as $cost)
                <tr class="text-center">
                    <td>هیات علمی</td>
                    <td>{{$cost->name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php $sum_spent=0;?>

                        @foreach($cost->spent as $spent)
                            @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                <?php   $sum_spent= $sum_spent+$spent->price ?>
                            @endif
                        @endforeach

                        {{$sum_spent}}

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            @endforeach


      {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $subaction=$subactions->find(33);
             @endphp
            @foreach($subaction->costs as $cost)
                <tr class="text-center">
                    <td>حقوق و مزایای کارکنان غیر هیات علمی</td>
                    <td>{{$cost->name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php $sum_spent=0;?>

                        @foreach($cost->spent as $spent)
                            @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                <?php   $sum_spent= $sum_spent+$spent->price ?>
                            @endif
                        @endforeach

                        {{$sum_spent}}

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            @endforeach
            {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $subaction=$subactions->find(34);
            @endphp
            @foreach($subaction->costs as $cost)
                <tr class="text-center">
                    <td>حقوق و مزایای کارکنان عضو قراردادی خدماتی و قرارداد معین</td>
                    <td>{{$cost->name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php $sum_spent=0;?>

                        @foreach($cost->spent as $spent)
                            @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                <?php   $sum_spent= $sum_spent+$spent->price ?>
                            @endif
                        @endforeach

                        {{$sum_spent}}

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            @endforeach
            {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $cost=$cost->find(25);
            @endphp

                <tr class="text-center">
                    <td>پاداش پایان خدمت</td>
                    <td>{{$cost->name}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php $sum_spent=0;?>

                        @foreach($cost->spent as $spent)
                            @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                <?php   $sum_spent= $sum_spent+$spent->price ?>
                            @endif
                        @endforeach

                        {{$sum_spent}}

                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

            {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $cost=$cost->find(26);
            @endphp

            <tr class="text-center">
                <td>پاداش پایان خدمت</td>
                <td>{{$cost->name}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php $sum_spent=0;?>

                    @foreach($cost->spent as $spent)
                        @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                            <?php   $sum_spent= $sum_spent+$spent->price ?>
                        @endif
                    @endforeach

                    {{$sum_spent}}

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $cost=$cost->find(28);
            @endphp

            <tr class="text-center">
                <td>حق الزحمه مشاورین پشتیبانی و ستادی</td>
                <td>{{$cost->name}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php $sum_spent=0;?>

                    @foreach($cost->spent as $spent)
                        @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                            <?php   $sum_spent= $sum_spent+$spent->price ?>
                        @endif
                    @endforeach

                    {{$sum_spent}}

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $cost=$cost->find(27);
            @endphp

            <tr class="text-center">
                <td>خدمات رفاهی</td>
                <td>{{$cost->name}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php $sum_spent=0;?>

                    @foreach($cost->spent as $spent)
                        @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                            <?php   $sum_spent= $sum_spent+$spent->price ?>
                        @endif
                    @endforeach

                    {{$sum_spent}}

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $cost=$cost->find(29);
            @endphp

            <tr class="text-center">
                <td>دیون پرسنلی</td>
                <td>{{$cost->name}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php $sum_spent=0;?>

                    @foreach($cost->spent as $spent)
                        @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                            <?php   $sum_spent= $sum_spent+$spent->price ?>
                        @endif
                    @endforeach

                    {{$sum_spent}}

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            {{-- ---------------------------------------------------------------------------------------  --}}
            @php
                $cost=$cost->find(30);
            @endphp

            <tr class="text-center">
                <td>سایر هزینه های پرسنلی</td>
                <td>{{$cost->name}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php $sum_spent=0;?>

                    @foreach($cost->spent as $spent)
                        @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                            <?php   $sum_spent= $sum_spent+$spent->price ?>
                        @endif
                    @endforeach

                    {{$sum_spent}}

                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>

    </div>
@endsection
