@extends('layouts.app')

@section('content')

    <div class="modal fade" id="Modal1" tabindex="-1" role="dialog" data-show="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">اختصاص اعتبار به فعالیت </h5>

                </div>
                <div class="modal-body">
                    <form action="{{'/spents/confirm'}}" method="post" class="form-horizontal">
                        {{ csrf_field() }}

                        <h5>درخواست هزینه دیگری با شماره این شماره سند و شماره هزینه وجود دارد</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td>شماره سند:</td>
                                <td>{{$request->input('doc_number')}}</td>
                            </tr>
                            <tr>
                                <td>شماره هزینه:</td>
                                <td>{{$request->input('cost_id')}}</td>
                            </tr>
                        </table>
                        <input type="text" name="spentname" class="form-control" id="spentname" hidden="hidden"
                               value="{{$request->input('spentname')}}">
                        <input type="text" name="give_date" class="form-control" id="give_date" hidden="hidden"
                               value="{{$request->input('give_date')}}">
                        <input type="text" name="comments" class="form-control" id="comments" hidden="hidden"
                               value="{{$request->input('comments')}}">
                        <input type="text" name="cost_id" class="form-control" id="cost_id" hidden="hidden"
                               value="{{$request->input('cost_id')}}">
                        <input type="text" name="credit_code" class="form-control" id="credit_code" hidden="hidden"
                               value="{{$request->input('credit_code')}}">
                        <input type="text" name="price" class="form-control" id="price" hidden="hidden"
                               value="{{$request->input('price')}}">
                        <input type="text" name="subaction_id" class="form-control" id="subaction_id" hidden="hidden"
                               value="{{$request->input('subaction_id')}}">
                        <p>هزینه ثبت گردد؟</p>
                        <p>در صورت عدم انتخاب پس از 15 ثانیه به صفحه ثبت هزینه منتقل می شوید</p>
                    </form>

                </div>
                <div class="modal-footer">
                    <div class="btn-group "role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-primary">ثبت</button>
                        <a type="button" class="btn btn-danger"
                                href="{{url('/spents/'.$request->input('subaction_id').'/'.$request->input('cost_id'))}}">
                            بازگشت
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php


    header("refresh:15;url=/spents/" . $request->input('subaction_id') . '/' . $request->input('cost_id'));
    ?>
@endsection
@section('bottom_script')
    <script type="text/javascript">
        window.onload = function () {
            $('#Modal1').modal('show');
            console.log('hi');
        };
        $('#Modal1').on('hide.bs.modal', function (e) {
            console.log('hi');
        })
    </script>
@endsection
