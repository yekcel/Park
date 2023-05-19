<table class="table table-striped table-hover">
    <thead class="bg-primary text-white">
    <tr>
        <th class="text-center">ردیف</th>
        <th class="text-center"> نام واحد</th>
        <th class="text-center">عنوان گرنت</th>
        <th class="text-center">اعتبار مصوب</th>
        <th class="text-center">اعتبار تخصیص یافته</th>
        <th class="text-center">مبلغ هزینه( ریال)</th>
    </tr>
    </thead>
    <tbody>
    <?php $total_allocate=0;?>
    <?php $total_spent=0;?>
    <?php $i = 0;  ?>
    {{-- @foreach($subaction->spent->all() as $spent)--}}
    @foreach($contracts as $contract)

        <?php $i++;  ?>
        <tr class="text-center">

            <td><?php echo $i;  ?></td>
            <td>{{$contract->company->name}}</td>
            @if($contract->tittle==1)
                <td>قرارداد پشتیبانی</td>
            @elseif($contract->tittle==2)
                <td>سیدمانی</td>
            @elseif($contract->tittle==3)
                <td>کانون شکوفایی</td>
            @elseif($contract->tittle==4)
                <td>هسته تحقیقاتی دانشگاهی</td>
            @elseif($contract->tittle==5)
                <td>تجاری سازی</td>
            @endif
            <td>{{$contract->totalcredit?($contract->totalcredit):0}}</td>

            <td>
                <?php $con=0;?>
                @foreach($contract->conassign as $conassign)
                    @if($conassign->year==$year1)

                        <?php    $con=  $con+$conassign->price ?>
                        <?php    $total_allocate=  $total_allocate+$conassign->price ?>

                    @endif
                @endforeach
                {{number_format($con)}}
            </td>
            <td><?php $sum_spent=0;?>

                @foreach($contract->spent as $spent)
                    @if($spent->spend_date>=$d1 && $spent->spend_date<=$d2 )
                        <?php   $sum_spent= $sum_spent+$spent->price ?>
                    @endif
                @endforeach

                {{number_format($sum_spent)}}
                <?php    $total_spent=  $total_spent+$sum_spent?>
            </td>


        </tr>

    @endforeach
    <tr class="bg-dark text-white text-center">
        <td>گزارش عملکرد واحد های فناور پارک  </td>
        <td>سال {{$year1}}</td>
        <td>{{verta($d1)->format("Y/n/j")}}-{{verta($d2)->format("Y/n/j")}}</td>
        <td>مجموع</td>
        <td>{{ number_format($total_allocate)}}</td>
        <td>{{ number_format($total_spent)}}</td>

    </tr>
    </tbody>
</table>
