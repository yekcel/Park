@extends('layouts.app')

@section('title')
    گزارش عملکرد هزینه ای
@endsection

@section('content')

    <div class="card bg-light text-dark ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">گزارش عملکرد هزینه ای به تفکیک ریزفعالیت و موضوع هزینه</div>

            </div>
        </div>

        <div class="card-body ">
            <div class="card bg-secondary text-white ">
                <div class="card-header"> فیلتر گزارش</div>
                <div class="card-body ">
                    <form action="{{'/reports/spent_subaction'}}" method="post" class="form-inline">
                        {{ csrf_field() }}
                        <div class="container">
                            <div class="row">

                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="appin">برنامه</label>
                                        <select name="appin" class="form-control" id="appin">
                                            <option value="">لطفا برنامه را انتخاب نمایید...</option>
                                            @foreach($applications as $application)
                                                <option value="{{$application->id}}">{{$application->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="actin">فعالیت</label>
                                        <select name="actin" class="form-control" id="actin">
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="sain">ریزفعالیت</label>
                                        <select name="sain" class="form-control" id="sain">
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="subaction_code">کد ریزفعالیت</label>
                                        <input type="text" class="form-control" id="subaction_code"
                                               name="subaction_code"
                                               value="{{old('subaction_code')}}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm4">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="source_code">منبع اعتبار</label>
                                        <select name="source_code" class="form-control" id="source">
                                            <option value="">لطفا منبع اعتبار را انتخاب نمایید...</option>
                                            @foreach($sources as $source)
                                                <option value="{{$source->code}}">{{$source->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm4">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="credit">محل مصرف</label>
                                        <select name="credit" id="credits" class="form-control">
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm4">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="credit_code">کد محل مصرف</label>
                                        <input type="text" class="form-control" id="credit_code" name="credit_code"
                                               value="{{old('credit_code')}}">
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="cost">کد موضوع هزینه</label>
                                        <input type="text" class="form-control" id="cost" name="cost"
                                               value="{{old('cost')}}">
                                    </div>
                                </div>

                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="give_date">تاریخ هزینه از</label>
                                        <input type="text" name="give_date" class="form-control" id="give_date_picker">

                                    </div>
                                </div>
                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="start_date">تا</label>
                                        <input type="text" name="start_date" class="form-control"
                                               id="start_date_picker">

                                    </div>
                                </div>
                                <div class="col-sm3">
                                    <div class="form-group" style="padding-top: 10px">
                                        <label for="year">سال هزینه</label>
                                        <select name="year" class="form-control" id="year">
                                            <option value="">لطفا سال مصرف را انتخاب نمایید...</option>
                                            @foreach($yearts as $year)
                                                <option value="{{$year->name}}">{{$year->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
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
            <div class="row justify-content-end" style="margin:15px;">
                <div class="col-sm-2 ">
                    <form action="{{'/reports/export1'}}" method="post" class="form-inline">
                        {{ csrf_field() }}
                        <input type="text" name="app1" class="form-control" id="app1" hidden="hidden"
                               value="{{ $app1 }}">
                        <input type="text" name="act1" class="form-control" id="act1" hidden="hidden"
                               value="{{ $act1 }}">
                        <input type="text" name="sact1" class="form-control" id="sact1" hidden="hidden"
                               value="{{ $sact1 }}">
                        <input type="text" name="sacod1" class="form-control" id="sacod1" hidden="hidden"
                               value="{{ $sacod1 }}">
                        <input type="text" name="sdate1" class="form-control" id="sdate1" hidden="hidden"
                               value="{{ $sdate1 }}">
                        <input type="text" name="edate1" class="form-control" id="edate1" hidden="hidden"
                               value="{{ $edate1 }}">
                        <input type="text" name="year1" class="form-control" id="year1" hidden="hidden"
                               value="{{ $year1 }}">
                        <input type="text" name="src1" class="form-control" id="src1" hidden="hidden"
                               value="{{ $src1 }}">
                        <input type="text" name="crdt1" class="form-control" id="crdt1" hidden="hidden"
                               value="{{ $crdt1 }}">
                        <input type="text" name="cost1" class="form-control" id="cost1" hidden="hidden"
                               value="{{ $cost1 }}">
                        <input type="text" name="ctcode1" class="form-control" id="ctcode1" hidden="hidden"
                               value="{{ $ctcode1 }}">
                        <button type="submit" class="btn btn-success">خروجی اکسل</button>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
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
                    @foreach($spents as $spent)
                        <?php $i++;  ?>
                        <tr class="text-center">

                            <td><?php echo $i;  ?></td>
                            <td></td>
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

            </div>
            <div class="row">
                <div class="col-sm4 offset-5">
                    {{$spents->appends(Request::only(['application','actions','subactions','subaction_code','source_code','credit','credit_code','year','give_date','start_date','cost']))->links()}}
                </div>
            </div>

            {{--@include('reports.export1',$exspents)--}}
        </div>
    </div>


@endsection
@section('bottom_script')
    <script type="application/javascript">
        window.onload = function () {
            $('#appin').on('change', function (e) {
                console.log(e);

                var application_id = e.target.value;
                $.ajax({
                    type: 'GET',
                    url: '/applications/' + application_id + '/getAction',
                    success: function (data) {
                        if (!$.isEmptyObject(data)) {
                            //  console.log(data);
                            $('#actin').html(data);
                        } else {
                            $('#actin').html('');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            //---------------------------------------------------------
            $('#actin').on('change', function (e) {
                console.log(e);

                var action_id = e.target.value;
                $.ajax({
                    type: 'GET',
                    url: '/actions/' + action_id + '/getsubaction',
                    success: function (data) {
                        if (!$.isEmptyObject(data)) {
                            //  console.log(data);
                            $('#sain').html(data);
                        } else {
                            $('#sain').html('');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
            //----------------------------------------------------------
            $('#source').on('change', function (e) {
                console.log(e);

                var source_code = e.target.value;
                $.ajax({
                    type: 'GET',
                    url: '/spents/' + source_code + '/credit',
                    success: function (data) {
                        if (!$.isEmptyObject(data)) {
                            //  console.log(data);
                            $('#credits').html(data);
                        } else {
                            $('#credits').html('');
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        }

    </script>
@endsection

