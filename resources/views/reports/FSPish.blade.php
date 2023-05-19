@extends('layouts.app')

@section('title')
    هزینه های حمایت مالی از واحد های فناور پیش رشد
@endsection

@section('content')
    <div class="card bg-light text-dark ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">هزینه های حمایت مالی از واحد های فناور پیش رشد</div>

            </div>
        </div>

        <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">عنوان</th>
                        <th class="text-center">نام واحد</th>
                        <th class="text-center">عنوان گرنت</th>
                        <th class="text-center">تعداد</th>
                        <th class="text-center">کل اعتبار مصوب</th>
                        <th class="text-center">مصوب 97</th>
                        <th class="text-center">پرداخت تا پایان آذر 97</th>
                        <th class="text-center">تعهد باقی مانده 97</th>
                        <th class="text-center">تعهد 1398</th>
                        <th class="text-center">تعهد بعد از سال 1398</th>


                    </tr>
                    </thead>
                    <tbody>


                    @for ($x = 1; $x <14; $x++)
                        <?php   $subaction = $subactions->find($x);?>

                        <tr class="text-center">
                            <td>پیش رشد</td>
                            <td>{{$contract->company}}</td>

                            @if ($contract->tittle==1)
                                <td>قرارداد پشتیبانی</td>
                            @elseif($contract->tittle==2)
                                <td>سیدمانی</td>
                            @elseif($contract->tittle==3)
                                <td>کانون شکوفایی</td>
                                    @else
                                <td>--</td>
                            @endif
                            <td>{{$contract->spent_count}}</td>
                            <td>{{$contract->totalcredit}}</td>
                            <td><?php $sum_spent = 0;?>

                                @foreach($subaction->spent as $spent)
                                    @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                        <?php   $sum_spent = $sum_spent + $spent->price ?>
                                    @endif
                                @endforeach

                                {{$sum_spent}}

                            </td>
                            <td></td>
                            <td>  {{$subaction->spent_count}}</td>
                            <td></td>
                            <td></td>


                        </tr>

                    @endfor


                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
