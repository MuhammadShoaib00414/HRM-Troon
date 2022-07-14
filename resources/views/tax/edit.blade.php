
<div class="card bg-none card-box">
{{Form::model($tax,array('route' => array('tax.update', $tax->id), 'method' => 'PUT')) }}
    @csrf
    {{ Form::hidden('employee_id',$tax->id, array()) }}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('title', __('Title'),['class'=>'form-control-label']) }} <span class="text-danger">*</span>
            {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
    <div class="form-group col-md-6">
            {{ Form::label('tax_amount', __('Tax Amount'),['class'=>'form-control-label']) }}<span class="text-danger">*</span>
            {{ Form::number('tax_amount',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('tax_date', __('Tax Date'),['class'=>'form-control-label']) }}
            {{ Form::date('tax_date',null, array('class' => 'form-control','required'=>'required')) }}
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