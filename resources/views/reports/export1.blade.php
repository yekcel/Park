<table class="table ">
    <thead>
    <tr>
        <th class="text-center">شماره</th>
        <th class="text-center"> شماره سند</th>
        <th class="text-center">عنوان ریز فعالیت</th>
        <th class="text-center">کد ریز فعالیت</th>
        <th class="text-center">موضوع هزینه</th>
        <th class="text-center">کد موضوع هزینه</th>
        <th class="text-center">مبلغ (ریال)</th>
        <th class="text-center">محل مصرف</th>
        <th class="text-center">کد محل مصرف</th>
    </tr>
    </thead>
    <tbody>

    <?php $i = 0;  ?>
    {{-- @foreach($subaction->spent->all() as $spent)--}}
    @foreach($exspents as $spent)
        <?php $i++;  ?>
        <tr class="text-center">

            <td><?php echo $i;  ?></td>
            <td>{{$spent->num}}</td>
            <td>{{$spent->subaction->name}}</td>
            <td>{{$spent->subaction->subaction_code}}</td>
            <td>{{$spent->cost->name}}</td>
            <td>{{$spent->cost->cost_code}}</td>
            <td>{{$spent->price}}</td>
            <td>{{$spent->credit?$spent->credit->name:null}}</td>
            <td>{{$spent->credit?$spent->credit->credit_code:null}}</td>

        </tr>

    @endforeach

    </tbody>
</table>
