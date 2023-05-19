@extends('layouts.app')

@section('title')
    گزارش هزینه و درآمد برنامه ها
@endsection

@section('content')

    <div class="card bg-light text-dark ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10"> گزارش هزینه و درآمد برنامه ها</div>

            </div>
        </div>

        <div class="card-body ">
            <div class="card bg-secondary text-white ">
                <div class="card-header"> فیلتر گزارش</div>
                <div class="card-body ">
                    <form action="{{'/reports/Apps'}}" method="post" class="form-inline">
                        {{ csrf_field() }}
                        <div class="container">
                            <div class="row">



                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="yearip">سال هزینه</label>
                                        <select name="yearip" class="form-control" id="yearip">
                                            <option value="">لطفا سال مصرف را انتخاب نمایید...</option>
                                            @foreach($yearts as $year)
                                                <option value="{{$year->name}}" @if($year->name==$year1) selected @endif>{{$year->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-primary">اعمال فیلتر</button>
                            </div>
                        </div>


                    </form>


                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">شماره</th>
                        <th class="text-center">عنوان برنامه</th>
                        <th class="text-center">مبلغ درآمد(ریال)</th>
                        <th class="text-center">مبلغ هزینه(ریال)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $i = 0;  ?>
                    {{-- @foreach($subaction->spent->all() as $spent)--}}
                    @foreach($applications as $application)
                        <?php $i++;  ?>
                        <tr class="text-center">

                            <td><?php echo $i;  ?></td>
                            <td>{{$application->name}}</td>
                            <td>{{$application->price_total?number_format($application->price_total):0}}</td>
                            <td>{{$application->spent_total?number_format($application->spent_total):0}}</td>


                        </tr>

                    @endforeach

                    </tbody>
                </table>

            </div>


            {{--@include('reports.export1',$exspents)--}}
        </div>
    </div>


@endsection


