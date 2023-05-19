@extends('layouts.app')

@section('title')
    اختصاص بودجه به فعالیت های {{$appassign->application->name}}
@endsection

@section('content')
    <div class=" card bg-white">
        <div class="card-header">
            <div class="row">
                <h4>برنامه :{{$appassign->application->name}}</h4>

            </div>
            <div class="row">
                <h4>منبع درآمد :{{$appassign->source->name}}</h4>

            </div>

        </div>


        <div class="card-body">
            <p><span class="accent">مبلغ اعتبار: </span>{{number_format($appassign->price)}}</p>
            <p><span class="accent">سال اعتبار: </span>{{$appassign->budget->year}}</p>
            <p><span class="accent">توضیحات: </span>{{$appassign->comments}}</p>
            <p><span class="accent">اعتبار اختصاص داده شده به فعالیت ها: </span>{{$appassign->actassign?number_format($appassign->actassign->sum('price')):null}}</p>
            <p><span class="accent">اعتبار اختصاص داده نشده: </span>{{number_format($appassign->price-$appassign->actassign->sum('price'))}}</p>
            <div class="col-md-6 ">

            </div>
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-header">فعالیت های برنامه</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover" >
                        <thead>
                        <tr>
                            <th class="text-center">فعالیت</th>
                            <th class="text-center">مبلغ</th>
                            <th class="text-center">توضیحات</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($appassign->application->actions as $action)
                            <?php $finded=0 ?>
                            <tr>
                            <td>{{$action->name}}</td>
                            @foreach($appassign->actassign as $actassign)
                                @if ($actassign->action_id==$action->id)
                                    <td>{{$actassign->price?number_format($actassign->price):null}}</td>
                                    <td>{{$actassign->comments?$actassign->comments:null}}</td>
                                        <?php $finded=1 ?>
                                    @break;
                                @endif
                            @endforeach
                            @if($finded==1)
                                <td>
                                    <a href="{{url('assigns/editActassign/'.$actassign->id)}}"
                                       class="btn btn-warning btn-xs"style="width:100px">ویرایش</a>
                                    <a href="{{url('assigns/showact/'.$actassign->id)}}"
                                       class="btn btn-info btn-xs">اختصاص اعتبار به ریزفعالیت ها</a>
                                </td>
                                @else
                                <td>--</td>
                                <td>--</td>
                                <td>

                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModalLong<?php echo $action->id; ?>">اختصاص اعتبار
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalLong<?php echo $action->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">اختصاص اعتبار به فعالیت {{$action->name }}</h5>

                                                </div>
                                                <div class="modal-body">
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
                                                        <button type="submit" class="btn btn-primary" >ذخیره</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    <!--  <button type="button" class="btn btn-primary">Save changes</button>-->
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
            <div class="col-md-8 col-md-offset-2">

                <a class="btn btn-danger"  href="{{url('/assigns')}}">
                    بازگشت
                </a>
            </div>
        </div>
    </div>
@endsection

