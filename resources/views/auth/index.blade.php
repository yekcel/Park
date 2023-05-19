@extends('layouts.app')

@section('title')
    مدیریت کاربران
@endsection

@section('content')

    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">لیست کاربران </div>
                <div class="col-sm-2">
                    <a href="{{url('users/addUser')}}" class="btn btn-success btn-xs"><i class="fa fa-user-plus icon" style="padding-left: 2px;"></i> ایجاد کاربر جدید</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white ">
                    <tr>
                        <th class="text-center">شماره</th>
                        <th class="text-center">شماره کاربر</th>
                        <th class="text-center">نام کاربر</th>
                        <th class="text-center">آدرس ایمیل</th>

                        <th class="text-center">گروه دسترسی</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index=0; ?>
                    @foreach($users as $user)
                        <?php $index++ ?>
                        <tr class="text-center">
                            <td>{{$index}}</td>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->role==1)
                                    <span class="badge badge-pill badge-dark" style="font-size: 1em;">Full Access</span>
                                @elseif($user->role==2)
                                    <span class="badge badge-pill badge-warning" style="font-size: 1em;">Budget & Spents</span>
                                @elseif($user->role==3)
                                    <span class="badge badge-pill badge-info" style="font-size: 1em;">Spents Only</span>
                                @elseif($user->role==4)
                                    <span class="badge badge-pill badge-warning" style="font-size: 1em;">Report Only</span>
                                @elseif($user->role==5)
                                    <span class="badge badge-pill badge-info" style="font-size: 1em;">Company</span>

                                @endif
                            </td>

                            <td>
                                @if($user->status==0)
                                    <span class="badge badge-pill badge-success" style="font-size: 1em;">فعال</span>
                                @elseif($user->status==1)
                                    <span class="badge badge-pill badge-danger" style="font-size: 1em;">غیر فعال</span>

                                @endif
                            </td>
                            <td>  <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{url('users/edit/'.$user->id)}}"
                                       class="btn btn-warning "><i class="fa fa-edit icon" style="padding-left: 2px;"></i> ویرایش</a>
                                    @if($user->status==1)
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal"
                                                data-target="#restormodal<?php echo $user->id; ?>"><i class="fa fa-recycle icon" style="padding-left: 2px;"></i> فعال
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="restormodal<?php echo $user->id; ?>"
                                             tabindex="-1" role="dialog" >
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white" >
                                                        <p class="modal-title" style="margin: 0 auto;" >کاربر انتخاب شده  فعال گردد؟</p>

                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped teacherInfo">

                                                            <tr>
                                                                <th>نام کاربر :</th>
                                                                <td>{{$user->name}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th>آدرس ایمیل :</th>
                                                                <td>{{$user->email}}</td>

                                                            </tr>

                                                        </table>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{url('users/recycle/'.$user->id)}}"
                                                           class="btn btn-success "><i class="fa fa-recycle icon" style="padding-left: 2px;"></i>فعال شدن</a>
                                                        <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">بازگشت
                                                        </button>
                                                        <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--end modal--}}
                                    @else

                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                                data-target="#deletemodal<?php echo $user->id; ?>"><i class="fa fa-user-times icon" style="padding-left: 2px;"></i> غیرفعال
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deletemodal<?php echo $user->id; ?>"
                                             tabindex="-1" role="dialog" >
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white" >
                                                        <p class="modal-title" style="margin: 0 auto;" >کاربر انتخاب شده غیر فعال گردد؟</p>

                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-striped teacherInfo">

                                                            <tr>
                                                                <th>نام کاربر :</th>
                                                                <td>{{$user->name}}</td>
                                                            </tr>

                                                            <tr>
                                                                <th>آدرس ایمیل :</th>
                                                                <td>{{$user->email}}</td>

                                                            </tr>

                                                        </table>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{url('users/delete/'.$user->id)}}"
                                                           class="btn btn-danger "><i class="fa fa-user-times icon" style="padding-left: 2px;"></i>غیر فعال شدن</a>
                                                        <button type="button" class="btn btn-success"
                                                                data-dismiss="modal">بازگشت
                                                        </button>
                                                        <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--end modal--}}

                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
