@extends('layouts.app')

@section('title')
    واحد ها
@endsection

@section('content')

    <div class="card ">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-10">لیست واحد های فناور </div>
                <div class="col-sm-2">
                    <a href="{{url('companies/add')}}" class="btn btn-success btn-xs">ثبت واحد فناور جدید</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white ">
                    <tr>
                        <th class="text-center">شماره</th>

                        <th class="text-center">نام واحد</th>
                        <th class="text-center">سطح واحد</th>
                        <th class="text-center">نام رئیس</th>
                        <th class="text-center">شماره تماس</th>
                        <th class="text-center">شماره حساب</th>
                        <th class="text-center">وضعیت</th>
                        <th class="text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index=0; ?>
                    @foreach($companies as $company)
                        <?php $index++ ?>
                        <tr class="text-center">
                            <td>{{$index}}</td>

                            <td>{{$company->name}}</td>
                            <td>
                            @if($company->kind==0)
                                    <span class="badge badge-pill badge-danger" style="font-size: 1em;">بدون سطح</span>
                                @elseif($company->kind==1)
                                    <span class="badge badge-pill badge-warning" style="font-size: 1em;">پیش رشد</span>
                                @elseif($company->kind==2)
                                    <span class="badge badge-pill badge-info" style="font-size: 1em;">رشد</span>
                                @elseif($company->kind==3)
                                    <span class="badge badge-pill badge-success" style="font-size: 1em;">فناور</span>
                                @endif
                            </td>
                            <td>{{$company->boss}}</td>
                            <td>{{$company->phone}}</td>
                            <td>{{$company->accont_number}}</td>
                            <td>
                                @if($company->status==1)
                                    <span class="badge badge-pill badge-danger">حذف شده</span>
                                @endif
                               </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">

                                    <a href="{{url('companies/edit/'.$company->id)}}"
                                       class="btn btn-warning "><i class="fa fa-edit icon" style="padding-left: 2px;"></i> ویرایش</a>

                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal"
                                            data-target="#deletemodal<?php echo $company->id; ?>"><i class="fa fa-trash-o icon" style="padding-left: 2px;"></i> حذف
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="deletemodal<?php echo $company->id; ?>"
                                         tabindex="-1" role="dialog" >
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white" >
                                                    <p class="modal-title" style="margin: 0 auto;" >واحد فناور انتخاب شده حذف گردد؟</p>

                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-striped teacherInfo">

                                                        <tr>
                                                            <th>نام واحد :</th>
                                                            <td>{{$company->name}}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>نام رئیس :</th>
                                                            <td>{{$company->boss}}</td>

                                                        </tr>

                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{url('companies/delete/'.$company->id)}}"
                                                       class="btn btn-danger "><i class="fa fa-trash-o icon" style="padding-left: 2px;"></i>حذف</a>
                                                    <button type="button" class="btn btn-success"
                                                            data-dismiss="modal">بازگشت
                                                    </button>
                                                    <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{--end modal--}}
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
