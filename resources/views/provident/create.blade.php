<div class="card bg-none card-box">
    {{Form::open(array('url'=>'provident','method'=>'POST'))}}
    @csrf
    {{ Form::hidden('employee_id',$employee->id, array()) }}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('title', __('Title'),['class'=>'form-control-label']) }} <span class="text-danger">*</span>
            {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('employee_amount', __('Employee Amount'),['class'=>'form-control-label']) }}<span class="text-danger">*</span>
            {{ Form::number('employee_amount',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('employee_date', __('Employee Date'),['class'=>'form-control-label']) }}
            {{ Form::date('employee_date',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('employer_amout', __('Employer Amout'),['class'=>'form-control-label']) }}
            {{ Form::number('employer_amout',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('employer_date', __('Employer Date'),['class'=>'form-control-label']) }}
            {{ Form::date('employer_date',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}

</div>
<script>
    $(function () {
        $('input[type="text').keypress(function (e) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
                e.preventDefault();
                $('.errmsg').show();

                $('.errmsg').text('Please Enter Alphabate');
                $(".errmsg").show().delay(2000).fadeOut();
                return false;

            }
        });
    });
</script>
