<table class="table table-striped table-hover table-bordered">
    <thead class="bg-primary text-white">
    <tr>
        <th class="text-center">شماره</th>
        {{--   <th class="text-center">عنوان برنامه</th>
           <th class="text-center">عنوان فعالیت</th>--}}
        <th class="text-center">عنوان ریزفعالیت</th>
        <th class="text-center">واحد مجری</th>
        <th class="text-center">تصویب(ریال)</th>
        <th class="text-center">تخصیص(ریال)</th>
    </tr>
    </thead>
    <tbody>

    <?php $i = 0;  ?>
    <?php $total_allocate=0;?>
    <?php $total_budget=0;?>
    {{-- @foreach($subaction->spent->all() as $spent)--}}
    @foreach($subactions as $subaction)
        <?php $i++;
        if($subaction->price_total){
            $total_budget=$total_budget+ $subaction->price_total;
        }
        ?>
        <tr class="text-center">

            <td><?php echo $i;  ?></td>
            {{--  <td>{{$subaction->action->application->name}}</td>
              <td>{{$subaction->action->name}}</td>--}}
            <td>{{$subaction->name}}</td>
            <td>{{$subaction->agent}}</td>
            <td>{{$subaction->price_total?$subaction->price_total:0}}</td>
            <td>
                <?php $sum_allocate=0;?>
                @foreach($subaction->subassign as $subassign)
                    @if($subassign->actassign->appassign->budget->year==$year1 )
                        @foreach($subassign->allocate as $allocate)
                            @if($allocate->allocate_date>=$d1 && $allocate->allocate_date<=$d2 )
                                <?php   $sum_allocate= $sum_allocate+$allocate->allocate_price ?>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                <?php    $total_allocate=  $total_allocate+$sum_allocate ?>

                {{$sum_allocate}}

            </td>



        </tr>

    @endforeach
    <tr class="bg-dark text-white text-center">
        <td>گزارش بودجه سال {{$year1}}</td>
        <td>{{verta($d1)->format("Y/n/j")}}-{{verta($d2)->format("Y/n/j")}}</td>
        <td>مجموع</td>
        <td>{{ $total_budget}}</td>
        <td>{{ $total_allocate}}</td>
    </tr>
    </tbody>
</table>