<table class="table table-striped table-hover">
    <thead class="bg-info text-white">
    <tr>
        <th class="text-center">سال مالی</th>
        <th class="text-center">ریزفعالیت</th>
        <th class="text-center">هزینه</th>
        <th class="text-center">محل تامین اعتبار</th>
        <th class="text-center">مبلغ هزینه کرد(ریال)</th>
    </tr>
    </thead>
    <tbody>

    <?php $total_allocate=0;?>
    <?php $total_budget=0;?>
    @foreach($subactions as $subaction)
        @foreach($subaction->costs as $cost)
            <?php $ind=0; ?>
            @foreach($vsubcredits as $vsubcredit)
                @if($vsubcredit->cost_id== $cost->id && $vsubcredit->sub_id==$subaction->id)
                    <?php $ind++; ?>
                    <tr class="text-center">
                        <td>{{$vsubcredit->year}}</td>
                        <td>{{$vsubcredit->subaction}}</td>
                        <td>{{$vsubcredit->cost}}</td>
                        <td>{{$vsubcredit->credit_name}}</td>
                        <td>{{$vsubcredit->sum}}</td>
                        <?php    $total_allocate=  $total_allocate+$vsubcredit->sum ?>
                    </tr>
                @endif

            @endforeach
            @if($ind==0)
                <tr class="text-center">
                    <td>{{$year1}}</td>
                    <td>{{$subaction->name}}</td>
                    <td>{{$cost->name}}</td>
                    <td>-</td>
                    <td>0</td>

                </tr>
            @endif
        @endforeach
    @endforeach
    <tr class="bg-dark text-white text-center">
        <td>گزارش بودجه سال {{$year1}}</td>
        <td>{{verta($d1)->format("Y/n/j")}}-{{verta($d2)->format("Y/n/j")}}</td>
        <td></td>
        <td>مجموع</td>
        <td>{{ $total_allocate}}</td>
    </tr>
    </tbody>
</table>
