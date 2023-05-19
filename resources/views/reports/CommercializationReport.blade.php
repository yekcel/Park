@extends('layouts.app')

@section('title')
    اعتبارات مربوط به برنامه تجاری سازی یافته های پژوهشی
@endsection

@section('content')
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th class="text-center">فعالیت</th>
                <th class="text-center"> ریزفعالیت</th>
                <th class="text-center">مصوب 97</th>
                <th class="text-center">عملکرد نه ماهه 97</th>
                <th class="text-center">سنجه عملکرد</th>
                <th class="text-center">مقدار</th>
                <th class="text-center">اعتبار 1398</th>
                <th class="text-center">هزینه واحد سال 1398</th>


            </tr>
            </thead>
            <tbody>


            @for ($x = 1; $x <14; $x++)
                <?php   $subaction=$subactions->find($x);?>

                <tr class="text-center">
                    <td>{{$subaction->action->name}}</td>
                    <td>{{$subaction->name}}</td>
                    <td>{{$subaction->credit_total}}</td>

                    <td><?php $sum_spent=0;?>

                        @foreach($subaction->spent as $spent)
                            @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                                <?php   $sum_spent= $sum_spent+$spent->price ?>
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
@endsection
