@extends('layouts.app')

@section('title')
    تعین بودجه
@endsection
@section('style')

@endsection
@section('content')

    <div class="card ">
        <div class="card-header ">
            <div class="row">
                <div class="col-sm-10"><h4 class="text-success">لیست بودجه های مصوب ثبت شده</h4></div>
                <div class="col-sm-2">
                    <a href="{{url('assigns/add2bud')}}" class="btn btn-success"><i class="fa fa-plus icon" style="padding-left: 2px;"></i> ثبت بودجه مصوب جدید</a>
                </div>
            </div>
        </div>
        <div class="card-body">
          {{--  <div class="table-responsive">--}}
                <table class="table table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white">
                    <tr>
                        <th class="text-center">شماره</th>

                        <th class="text-center">منبع اعتبار</th>
                        <th class="text-center">سال مصرف</th>
                        <th class="text-center">تامین کننده</th>
                        <th class="text-center">تاریخ تصویب</th>
                        <th class="text-center">مبلغ مصوب</th>
                        <th class="text-center">اعتبار اختصاص یافته</th>
                        <th class="text-center">توضیحات</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index=0 ?>
                    @foreach($budgets as $budget)
                        <?php $index++ ?>
                        <tr class="text-center">
                            <td>{{$index}}</td>
                            {{-- <td>{{$budget->id}}</td>--}}
                            <td>{{$budget->source->name}}</td>
                            <td>{{$budget->year}}</td>
                            <td>
                                @if($budget->supplier==1)
                                    <span class="badge badge-pill badge-success " style="font-size: 1em;">سازمان برنامه و بودجه</span>
                                @elseif($budget->supplier=='2')
                                    <span class="badge badge-pill badge-primary" style="font-size: 1em;">انتقالی</span>
                                @elseif($budget->supplier=='3')
                                    <span class="badge badge-pill badge-warning" style="font-size: 1em;">سایر</span>
                                @endif
                            </td>
                            <td>{{$budget->date?Verta::instance($budget->date)->formatJalaliDate():null}}</td>
                            <td>{{number_format($budget->approved_price)}}</td>
                            <td>{{number_format($budget->price)}}</td>
                            <td>{{$budget->comments}}</td>
                            <td>
                               {{-- <div>--}}
                                    <a href="{{url('assigns/budgetshow/'.$budget->id)}}"
                                       class="btn btn-dark "><i class="fa fa-sitemap icon" style="padding-left: 2px;"></i> نمایش بودجه و برنامه ها </a>
                                    <a href="{{url('assigns/editBudget/'.$budget->id)}}"
                                       class="btn btn-warning "><i class="fa fa-edit icon" style="padding-left: 3px;"></i> ویرایش</a>
                                    <a href="{{url('assigns/deleteBudget/'.$budget->id)}}"
                                       class="btn btn-danger "><i class="fa fa-trash-o icon" style="padding-left: 2px;"></i> حذف</a>
                                    <button type="button" class="btn btn-primary " data-toggle="modal"
                                            data-target="#allocatmodal<?php echo $budget->id; ?>"><i class="fa fa-list icon" style="padding-left: 2px;"></i>اختصاص اعتبار
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="allocatmodal<?php echo $budget->id; ?>"
                                         tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document" style="min-width: 650px">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-success" style="margin: 0 auto;" id="exampleModalLongTitle"><i class="fa fa-list icon" style="padding-left: 2px;"></i> تخصیص اعتبار دریافتی </h5>

                                                </div>
                                                <div class="modal-body">
                                                    <div class="container text-right">
                                                        <p>منبع اعتبار:
                                                        <span style="color: #1f6fb2;font-size: large;">{{$budget->source->name}}</span></p>
                                                        <p>سال:
                                                            <span style="color: #1f6fb2;font-size: large;">{{$budget->year}}</span></p>
                                                    <div class="card text-center">
                                                        <div class="card-header">لیست اعتبارات تخصیص یافته</div>
                                                        <div class="card-body">
                                                            <div class="row bg-white ">
                                                    <table class="table table-bordered table-striped table-hover ">
                                                        <thead class="bg-primary text-white">
                                                        <th class="text-center" >تاریخ تخصیص اعتبار</th>
                                                        <th class="text-center" >مبلغ تخصیص</th>
                                                        <th class="text-center" >توضیحات</th>
                                                        <th class="text-center" style="width: 250px">عملیات</th>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($budget->allocate as $allocate)
                                                            <tr>
                                                                <td>{{$allocate->allocate_date?Verta::instance($allocate->allocate_date)->formatJalaliDate():null}}</td>
                                                                <td>{{number_format($allocate->allocate_price)}}</td>

                                                                <td>{{$allocate->comments}}</td>
                                                                <td>
                                                                    <a class="btn btn-warning btn-xs" style="width:100px"
                                                                       onClick="act(this,'{{$allocate->id}}','{{$allocate->allocate_price}}','{{Verta::instance($allocate->allocate_date)->formatJalaliDate()}}','{{$allocate->comments}}')">
                                                                        <i class="fa fa-edit icon" style="padding-left: 3px;"></i> ویرایش </a>
                                                                    <a class="btn btn-danger btn-xs" href="{{url('allocate/'.$allocate->id.'/deletebud')}}" style="width:100px">
                                                                        <i class="fa fa-trash-o icon" style="padding: 2px;"></i>حذف</a>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  {{--  <div class="card ">
                                                        <div class="card-header">تخصیص اعتبار جدید</div>
                                                        <div class="card-body">
                                                            <div class="row bg-white ">--}}
                                                        <hr>
                                                        <form action="{{'/assigns/allocate_budget/'.$budget->id}}" method="post" class="form-horizontal" id="form1" >
                                                            {{ csrf_field() }}

                                                            <div class=" row form-group">
                                                                <label for="person">مبلغ*</label>

                                                                <input type="text" name="price" class="form-control price1" id="price" style="width: 100%"
                                                                       placeholder="لطفا مبلغ اعتبار را وارد نمایید" value="{{ old('price') }}">




                                                            </div>
                                                            <div class="form-group">
                                                                <label for="give_date" >تاریخ تخصیص</label>

                                                                <input type="text" name="give_date" class="form-control DatePicker" id="give_date_picker" >



                                                            </div>


                                                            <div class="form-group">
                                                                <label for="comments" >توضیحات</label>

                                                                <textarea type="text" name="comments" class="form-control comment1" id="comments"></textarea>

                                                            </div>


                                                            <button type="submit" class="btn btn-success btn1" id="btn1" style="width: 150px; ">اضافه کردن </button>
                                                            <input type="button" class="btn btn-primary btn2" id="btn2" style="width: 150px; " onclick="act2(this,'{{$budget->id}}')" value="انصراف">
                                                            <script>
                                                                document.getElementById('btn2').style.visibility = 'hidden';
                                                            </script>
                                                        </form>



                                                           {{-- </div>
                                                        </div>
                                                    </div>--}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
                                                    </button>
                                                    <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--end modal--}}

                               {{-- </div>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
           {{-- </div>--}}
        </div>
    </div>
@endsection
@section('bottom_script')
    <script>
        function act(elem,str1, str2, str3,str4) {
            var cont =$(elem).closest('.container');

            console.log($(elem));
            //$('#form1').attr('action', '/allocate/' + str1 + '/editsub');
            cont.find('.form1').attr('action', '/allocate/' + str1 + '/editbud');
            cont.find('.price1').val(str2);

            // $("#give_date_picker").val(str3);
            cont.find('.DatePicker').val(str3);
            // $("#comments").val(str4);
            cont.find('.comment1').val(str4);
            //  $('#btn1').text('تغییر');
            cont.find('.btn1').text('تغییر');
            cont.find('.btn2').css( {"visibility": "visible"});
            //document.getElementById('btn2').style.visibility = 'visible';
        }
        function act2(elem,str1) {
            var cont =$(elem).closest('.container');


            //$('#form1').attr('action', '/allocate/' + str1 + '/editsub');
            cont.find('.form1').attr('action', '/assigns/allocate_budget/' + str1);
            console.log(str1);

            cont.find('.btn2').css( {"visibility": "hidden"});
            cont.find('.price1').val('');
            cont.find('.DatePicker').val('');
            cont.find('.comment1').val('');
            cont.find('.btn1').text('اضافه کردن');
        }

    </script>


@endsection
