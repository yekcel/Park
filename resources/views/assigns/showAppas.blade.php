@extends('layouts.app')

@section('title')
    تصویب و اختصاص بودجه برای فعالیت ها
@endsection

@section('content')
   <div class=" card bg-white" style="border-color: #2d995b">
        <div class="card-header">
            <div class="row">
                <h4 class=" text-primary" >  تصویب و اختصاص بودجه برای فعالیت ها</h4>
            </div>
        </div>
        <div class="card-body">
        <table class="table table-striped teacherInfo">

            <tr>
                <th>منبع درآمد :</th>
                <td>{{$appassign->budget->source->name}}</td>
                <th>تامین کننده بودجه :</th>
                <td>
                    @if($appassign->budget->supplier==1)
                        سازمان برنامه و بودجه
                    @elseif($appassign->budget->supplier=='2')
                        انتقالی
                    @elseif($appassign->budget->supplier=='3')
                        سایر
                    @endif
                </td>
                <th>سال مصرف :</th>
                <td>{{$appassign->budget->year}}</td>
            </tr>

            <tr>
                <th>توضیحات :</th>
                <td>{{$appassign->comments}}</td>

            </tr>

            <tr>
                <th>مبلغ بودجه مصوب :</th>
                <td>{{number_format($appassign->approved_price).' ریال'}}</td>
                <th>مبلغ مصوب شده بودجه  برای فعالیت ها :</th>
                <td>{{$appassign->actassign?number_format($appassign->actassign->sum('approved_price')).' ریال':null}}</td>
                <th>بودجه مصوب نشده :</th>
                <td>{{$appassign->actassign?number_format($appassign->approved_price-$appassign->actassign->sum('approved_price')).' ریال':number_format($appassign->approved_price).' ریال'}}</td>
            </tr>
            <tr>
                <th>مبلغ اعتبار دریافت شده :</th>
                <td>{{number_format($appassign->price).' ریال'}}</td>
                <th>اعتبار اختصاص یافته به برنامه ها :</th>
                <td>{{$appassign->actassign?number_format($appassign->actassign->sum('price')).' ریال':0}}</td>
                <th>اعتبار اختصاص داده نشده :</th>
                <td>{{$appassign->actassign?number_format($appassign->price-$appassign->actassign->sum('price')).' ریال':number_format($appassign->price).' ریال'}}</td>
            </tr>
        </table>
        </div>


                <div class="card" style="border-color: #0c52de; margin: 2px">
                <div class="card-header bg-primary" style="background: linear-gradient(90deg,#2991f6,#150f50); ">
                    <div class="row">
                        <div class="col-sm-10"><h4 class="text-white"><i class="fa fa-sitemap icon" style="padding-left: 2px;"></i> لیست فعالیت ها و بودجه</h4></div>
                        <div class="col-sm-2">
                            <a href="{{url('assigns/budgetshow/'.$appassign->budget->id)}}" class="btn btn-dark"><i class="fa fa-level-up icon" style="padding-left: 2px;"></i> بازگشت</a>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center">فعالیت</th>
                            <th class="text-center">بودجه تصویب شده</th>
                            <th class="text-center">اعتبار اختصاص یافته</th>
                            <th class="text-center">توضیحات</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($appassign->application->action as $action)
                            <?php $finded=0 ?>
                            <tr class="text-center">
                                <td>{{$action->name}}</td>
                                @foreach($appassign->actassign as $actassign)
                                    @if ($actassign->action_id==$action->id)
                                        <td>{{$actassign->approved_price?number_format($actassign->approved_price):0}}</td>
                                        <td>{{$actassign->price?number_format($actassign->price):0}}</td>
                                        <td>{{$actassign->comments?$actassign->comments:null}}</td>
                                        <?php $finded=1 ?>
                                        @break;
                                    @endif
                                @endforeach
                                @if($finded==1)
                                    <td>
                                        <a href="{{url('assigns/showact/'.$actassign->id)}}"
                                           class="btn btn-dark btn-xs"><i class="fa fa-sitemap icon" style="padding-left: 2px;"></i>نمایش بودجه و ریزفعالیت ها</a>

                                        <button type="button" class="btn btn-warning " data-toggle="modal"
                                                data-target="#editmodal<?php echo $action->id; ?>"><i class="fa fa-edit icon" style="padding-left: 3px;"></i> ویرایش بودجه مصوب
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editmodal<?php echo $action->id; ?>"
                                             tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="min-width: 650px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success" style="margin: 0 auto;" id="exampleModalLongTitle"><i class="fa fa-edit icon" style="padding-left: 2px;"></i> ویرایش بودجه مصوب فعالیت {{$action->name }} </h5>

                                                    </div>
                                                    <div class="modal-body text-right">
                                                        <form action="{{'/assigns/editActassign/'.$appassign->id.'/'.$actassign->id}}" method="post"
                                                              class="form-horizontal">
                                                            {{ csrf_field() }}
                                                            {{method_field('PATCH')}}
                                                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                                <label for="price" class="col-sm-8 control-label">مبلغ
                                                                    اعتبار*</label>
                                                                <div class=" col-sm-8">
                                                                    <input type="text" name="price" class="form-control"
                                                                           id="price"
                                                                           placeholder="لطفا مبلغ اعتبار را وارد نمایید"
                                                                           value="{{ $errors->has('price')?old('price'):$actassign->approved_price }}">ریال



                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="comments" class="col-sm-4 control-label">توضیحات</label>
                                                                <div class="col-sm-8">
                                                                    <textarea type="text" name="comments"
                                                                              class="form-control"
                                                                              id="comments">@php  if($actassign->comments!=null){echo $actassign->comments;}  @endphp</textarea>
                                                                </div>
                                                            </div>


                                                            <button type="submit" class="btn btn-success " style="width: 150px; "><i class="fa fa-save icon" style="padding-left: 2px;"></i> ثبت تغییرات </button>
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
                                                data-target="#allocatmodal<?php echo $actassign->id; ?>"><i class="fa fa-list icon" style="padding-left: 2px;"></i>اختصاص اعتبار
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="allocatmodal<?php echo $actassign->id; ?>"
                                             tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
                                             aria-hidden="true">
                                            <div class="modal-dialog" role="document"  style="min-width: 650px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success" style="margin: 0 auto;" id="exampleModalLongTitle"><i class="fa fa-list icon" style="padding-left: 2px;"></i>تخصیص اعتبار دریافتی </h5>

                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container text-right">
                                                            <p>منبع اعتبار:
                                                                <span style="color: #1f6fb2;font-size: large;">{{$actassign->appassign->budget->source->name}}</span></p>
                                                            <p>برنامه:
                                                                <span style="color: #1f6fb2;font-size: large;">{{$actassign->action->name}}</span></p>
                                                            <div class="card text-center">
                                                                <div class="card-header">اعتبارات تخصیص یافته</div>
                                                                <div class="card-body">
                                                                    <div class="row bg-white ">
                                                                        <table class="table table-bordered table-striped table-hover ">
                                                                            <thead class="bg-primary text-white">
                                                                            <th class="text-center" >تاریخ تخصیص اعتبار</th>
                                                                            <th class="text-center" >مبلغ تخصیص</th>
                                                                            <th class="text-center" >توضیحات</th>
                                                                            <th class="text-center" style="width: 250px" >عملیات</th>
                                                                            </thead>
                                                                            <tbody>
                                                                            @foreach($actassign->allocate as $allocate)
                                                                                <tr>
                                                                                    <td>{{Verta::instance($allocate->allocat_date)->formatJalaliDate()}}</td>
                                                                                    <td>{{number_format($allocate->allocate_price)}}</td>

                                                                                    <td>{{$allocate->comments}}</td>
                                                                                    <td>
                                                                                        <a class="btn btn-warning btn-xs" style="width:100px"
                                                                                           onClick="act(this,'{{$allocate->id}}','{{$allocate->allocate_price}}','{{Verta::instance($allocate->allocate_date)->formatJalaliDate()}}','{{$allocate->comments}}')"><i class="fa fa-edit icon" style="padding-left: 3px;"></i> ویرایش</a>
                                                                                        <a class="btn btn-danger btn-xs" href="{{url('allocate/'.$allocate->id.'/deleteact')}}" style="width:100px"><i class="fa fa-trash-o icon" style="padding: 2px;"></i> حذف</a>


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

                                                                <form action="{{'/assigns/allocate_act/'.$actassign->id}}" method="post" class="form-horizontal form1" >
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
                                                                    <input type="button" class="btn btn-primary btn2" id="btn2" style="width: 150px; " onclick="act2(this,'{{$actassign->id}}')" value="بازگشت">
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

                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModalLong<?php echo $action->id; ?>"><i class="fa fa-save icon" style="padding-left: 2px;"></i>ثبت بودجه مصوب
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalLong<?php echo $action->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document"  style="min-width: 650px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-success" style="margin: 0 auto;" id="exampleModalLongTitle"><i class="fa fa-save icon" style="padding-left: 2px;"></i> ثبت بودجه مصوب فعالیت {{$action->name }} </h5>

                                                    </div>
                                                    <div class="modal-body text-right">
                                                        <form action="{{'/assigns/add2act/'.$appassign->id}}" method="post" class="form-horizontal">
                                                            {{ csrf_field() }}
                                                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                                                <label for="price" class="col-sm-4 control-label">مبلغ اعتبار*</label>
                                                                <div class="col-sm-8">
                                                                    <input type="text" name="price" class="form-control" id="price"
                                                                           placeholder="لطفا مبلغ اعتبار را وارد نمایید" value="{{ old('price') }}">ریال

                                                                    @if ($errors->has('price'))
                                                                        <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="comments" class="col-sm-4 control-label">توضیحات</label>
                                                                <div class="col-sm-8">
                                                                    <textarea type="text" name="comments" class="form-control" id="comments"></textarea>
                                                                </div>
                                                            </div>

                                                            <input type="text" name="year" class="form-control" id="year" hidden="hidden" value="{{ $appassign->year }}">
                                                            <input type="text" name="appassign" class="form-control" id="appassign" hidden="hidden" value="{{ $appassign->id }}">
                                                            <input type="text" name="source" class="form-control" id="source" hidden="hidden" value="{{ $appassign->source_id }}">
                                                            <input type="text" name="action" class="form-control" id="action" hidden="hidden" value="{{ $action->id }}">
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
            cont.find('.form1').attr('action', '/allocate/' + str1 + '/editact');
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
            cont.find('.form1').attr('action', '/assigns/allocate_act/' + str1);
            console.log(str1);

            cont.find('.btn2').css( {"visibility": "hidden"});
            cont.find('.price1').val('');
            cont.find('.DatePicker').val('');
            cont.find('.comment1').val('');
            cont.find('.btn1').text('اضافه کردن');
        }

    </script>

@endsection
