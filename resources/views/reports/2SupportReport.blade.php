@extends('layouts.app')

@section('title')
    هزینه های پشتیبانی
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="text-center">نوع هزینه</th>
                <th class="text-center"> موضوع هزینه</th>
                <th class="text-center">مصوب 97</th>
                <th class="text-center">عملکرد نه ماهه 97</th>
                <th class="text-center">ضریب افزایش</th>
                <th class="text-center">پیش بینی اولیه 98</th>
                <th class="text-center">بارمالی ناشی از کاهش عملیات</th>
                <th class="text-center">بارمالی ناشی از افزایش عملیات</th>
                <th class="text-center">جمع اعتبار 98</th>

            </tr>
            </thead>
            <tbody>
            @for ($x = 36; $x <45; $x++)
               <?php   $subaction=$subactions->find($x);?>
            @foreach($subaction->costs as $cost)
                <tr class="text-center">
                    <td>{{$subaction->name}}</td>
                    <td>{{$cost->name}}</td>
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

                </tr>

            @endforeach
            @endfor


            </tbody>
        </table>

    </div>
@endsection
