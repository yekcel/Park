<option value="">لطفا نوع مصرف را انتخاب نمایید...</option>
@foreach($credits as $key=>$val)
    <option value="{{$key}}">{{$val}}</option>
@endforeach