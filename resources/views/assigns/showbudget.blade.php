@extends('layouts.app')

@section('title')
   تصویب و اختصاص بودجه برای برنامه ها
@endsection

@section('content')
            <div class=" card bg-white" style="border-color: #2d995b">
        <div class="card-header  text-primary">

            <div class="row">
                <h4 > تصویب و اختصاص بودجه برای برنامه ها</h4>

            </div>

        </div>
        <div class="card-body">
        <table class="table table-striped teacherInfo">

            <tr>
                <th>منبع درآمد :</th>
                <td>{{$budget->source->name}}</td>
                <th>تامین کننده بودجه :</th>
                <td> @if($budget->supplier==1)
                        سازمان برنامه و بودجه
                    @elseif($budget->supplier=='2')
                        انتقالی
                    @elseif($budget->supplier=='3')
                        سایر
                    @endif</td>
                <th>سال مصرف :</th>
                <td>{{$budget->year}}</td>
            </tr>

            <tr>
                <th>توضیحات :</th>
                <td>{{$budget->comments}}</td>

            </tr>

            <tr>
                <th>مبلغ بودجه مصوب :</th>
                <td>{{number_format($budget->approved_price).' ریال'}}</td>
                <th>مبلغ مصوب شده بودجه  برای برنامه ها :</th>
                <td>{{$budget->appassign?number_format($budget->appassign->sum('approved_price')).' ریال':null}}</td>
                <th>بودجه مصوب نشده :</th>
                <td>{{$budget->appassign?number_format($budget->approved_price-$budget->appassign->sum('approved_price')).' ریال':number_format($budget->approved_price).' ریال'}}</td>
            </tr>
            <tr>
                <th>مبلغ اعتبار دریافت شده :</th>
                <td>{{number_format($budget->price)}}</td>
                <th>اعتبار اختصاص یافته به برنامه ها :</th>
                <td>{{$budget->appassign?number_format($budget->appassign->sum('price')):0}}</td>
                <th>اعتبار اختصاص داده نشده :</th>
                <td>{{$budget->appassign?number_format($budget->price-$budget->appassign->sum('price')):number_format($budget->price)}}</td>
            </tr>
        </table>
        </div>


                <div class="card" style="border-color: #0c52de; margin: 2px">
                <div class="card-header bg-primary text-white" style="background: linear-gradient(90deg,#2991f6,#150f50); ">
                    <div class="row">
                        <div class="col-sm-10"><h4 class="text-white" ><i class="fa fa-sitemap icon" style="padding-left: 2px;"></i> لیست برنامه ها و بودجه</h4></div>
                        <div class="col-sm-2">
                            <a href="{{url('/assigns')}}" class="btn btn-dark"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center">برنامه</th>
                            <th class="text-center">بودجه تصویب شده</th>
                            <th class="text-center">اعتبار اختصاص یافته</th>
                            <th class="text-center">توضیحات</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($applications as $application)
                            <?php $finded = 0 ?>
                            <tr class="text-center">
                                <td>{{$application->name}}</td>
                                @foreach($budget->appassign as $appassign)
                                    @if ($appassign->application_id==$application->id)
                                        <td>{{$appassign->approved_price?number_format($appassign->approved_price):0}}</td>
                                        <td>{{$appassign->price?number_format($appassign->price):0}}</td>
                                        <td>{{$appassign->comments?$appassign->comments:null}}</td>
                                        <?php $finded = 1 ?>
                                        @break
                                    @endif
                                @endforeach
                                @if($finded==1)
                                    <td>
                                        <a href="{{url('assigns/showAppassign/'.$appassign->id)}}"
                                           class="btn btn-dark"><i class="fa fa-sitemap icon" style="padding-left: 2px;"></i> نمایش بودجه و فعالیت ها</a>
                                        <button type="button" class="btn btn-warning " data-toggle="modal"
                                                data-target="#editmodal<?php echo $application->id; ?>"><i class="fa fa-edit icon" style="padding-left: 3px;"></i> ویرایش بودجه مصوب
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editmodal<?php echo $application->id; ?>"
                                             tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="min-width: 650px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success" style="margin: 0 auto;" id="exampleModalLongTitle"><i class="fa fa-edit icon" style="padding-left: 2px;"></i> ویرایش بودجه مصوب برنامه {{$application->name }} </h5>

                                                    </div>

                                                    <div class="modal-body text-right">
                                                        <form action="{{'/assigns/editAppassign/'.$appassign->id}}" method="post"
                                                              class="form-horizontal">
                                                            {{ csrf_field() }}
                                                            {{method_field('PATCH')}}
                                                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                                <label for="price" class="col-sm-4 control-label">مبلغ
                                                                    بودجه*</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="price" class="form-control"
                                                                           id="price"
                                                                           placeholder="لطفا مبلغ بودجه را وارد نمایید"
                                                                           value="{{ $errors->has('price')?old('price'):$appassign->approved_price }}">ریال



                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="comments" class="col-sm-4 control-label">توضیحات</label>
                                                                <div class="col-sm-8">
                                                                    <textarea type="text" name="comments"
                                                                              class="form-control"
                                                                              id="comments">@php  if($appassign->comments!=null){echo $appassign->comments;}  @endphp</textarea>
                                                                </div>
                                                            </div>


                                                            <button type="submit" class="btn btn-warning " style="width: 150px; "><i class="fa fa-save icon" style="padding-left: 2px;"></i> ثبت تغییرات </button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--end modal--}}

                                        <button type="button" class="btn btn-primary " data-toggle="modal"
                                                data-target="#allocatmodal<?php echo $appassign->id; ?>"><i class="fa fa-list icon" style="padding-left: 2px;"></i>اختصاص اعتبار
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="allocatmodal<?php echo $appassign->id; ?>"
                                             tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="min-width: 650px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success" style="margin: 0 auto;" id="exampleModalLongTitle"><i class="fa fa-list icon" style="padding-left: 2px;"></i>تخصیص اعتبار دریافتی </h5>

                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container text-right">
                                                            <p>منبع اعتبار:
                                                                <span style="color: #1f6fb2;font-size: large;">{{$appassign->budget->source->name}}</span></p>
                                                            <p>برنامه:
                                                                <span style="color: #1f6fb2;font-size: large;">{{$appassign->application->name}}</span></p>
                                                            <div class="card text-center">
                                                                <div class="card-header">اعتبارات تخصیص یافته</div>
                                                                <div class="card-body">
                                                                    <div class="row bg-white ">
                                                                        <table class="table table-bordered table-striped table-hover ">
                                                                            <thead class="bg-primary text-white">
                                                                            <th class="text-center" >تاریخ تخصیص اعتبار</th>
                                                                            <th class="text-center" >مبلغ تخصیص</th>
                                                                            <th class="text-center" >توضیحات</th>
                                                                            <th class="text-center"  style="width: 250px">عملیات</th>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach($appassign->allocate as $allocate)
                                                                                <tr>
                                                                                    <td>{{$allocate->allocate_date?Verta::instance($allocate->allocate_date)->formatJalaliDate():null}}</td>
                                                                                    <td>{{number_format($allocate->allocate_price)}}</td>

                                                                                    <td>{{$allocate->comments}}</td>
                                                                                    <td>
                                                                                        <a class="btn btn-warning btn-xs" style="width:100px"
                                                                                           onClick="act(this,'{{$allocate->id}}','{{$allocate->allocate_price}}','{{Verta::instance($allocate->allocate_date)->formatJalaliDate()}}','{{$allocate->comments}}')"><i class="fa fa-edit icon" style="padding-left: 3px;"></i> ویرایش</a>
                                                                                        <a class="btn btn-danger btn-xs" href="{{url('allocate/'.$allocate->id.'/deleteapp')}}" style="width:100px"><i class="fa fa-trash-o icon" style="padding: 2px;"></i> حذف</a>

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

                                                                <form action="{{'/assigns/allocate_app/'.$appassign->id}}" method="post" class="form-horizontal form1" >
                                                                    {{ csrf_field() }}

                                                                    <div class="form-group">
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
                                                                    <input type="button" class="btn btn-primary btn2" id="btn2" style="width: 150px; " onclick="act2(this,'{{$appassign->id}}')" value="بازگشت">
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




                                    </td>
                                @else
                                    <td>--</td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td>

                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                                data-target="#exampleModalLong<?php echo $application->id; ?>"><i class="fa fa-save icon" style="padding-left: 2px;"></i> ثبت بودجه مصوب</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalLong<?php echo $application->id; ?>"
                                             tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document"  style="min-width: 650px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success" style="margin: 0 auto;" id="exampleModalLongTitle"><i class="fa fa-save icon" style="padding-left: 2px;"></i>ثبت بودجه مصوب برنامه {{$application->name }} </h5>

                                                    </div>
                                                    <div class="modal-body text-right">
                                                        <form action="{{'/assigns/addtoapp/'.$budget->id}}" method="post"
                                                              class="form-horizontal">
                                                            {{ csrf_field() }}
                                                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                                <label for="price" class="col-sm-4 control-label">مبلغ
                                                                    اعتبار*</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="price" class="form-control numberformat"
                                                                           id="price"
                                                                           placeholder="لطفا مبلغ بودجه را وارد نمایید"
                                                                           value="{{ old('price') }}">ریال



                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="comments" class="col-sm-4 control-label">توضیحات</label>
                                                                <div class="col-sm-8">
                                                                    <textarea type="text" name="comments"
                                                                              class="form-control"
                                                                              id="comments"></textarea>
                                                                </div>
                                                            </div>

                                                            <input type="text" name="year" class="form-control"
                                                                   id="year" hidden="hidden"
                                                                   value="{{ $budget->year }}">
                                                            <input type="text" name="budget" class="form-control"
                                                                   id="budget" hidden="hidden"
                                                                   value="{{ $budget->id }}">
                                                            <input type="text" name="source" class="form-control"
                                                                   id="source" hidden="hidden"
                                                                   value="{{ $budget->source_id }}">
                                                            <input type="text" name="application" class="form-control"
                                                                   id="application" hidden="hidden"
                                                                   value="{{ $application->id }}">
                                                            <button type="submit" class="btn btn-success " style="width: 150px; "><i class="fa fa-save icon" style="padding-left: 2px;"></i> ذخیره </button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal"><i class="fa fa-close icon" style="padding-left: 2px;"></i> Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--end modal--}}

                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
    </div>



@endsection
@section('bottom_script')
    <script>
        function act(elem,str1, str2, str3,str4) {
            var cont =$(elem).closest('.container');

            console.log($(elem));
            //$('#form1').attr('action', '/allocate/' + str1 + '/editsub');
            cont.find('.form1').attr('action', '/allocate/' + str1 + '/editapp');
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
            cont.find('.form1').attr('action', '/assigns/allocate_app/' + str1);
            console.log(str1);

            cont.find('.btn2').css( {"visibility": "hidden"});
            cont.find('.price1').val('');
            cont.find('.DatePicker').val('');
            cont.find('.comment1').val('');
            cont.find('.btn1').text('اضافه کردن');
        }

    </script>

@endsection
