<div class="card bg-none card-box">
    {{Form::model($saturationdeduction,array('route' => array('saturationdeduction.update', $saturationdeduction->id), 'method' => 'PUT')) }}
    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('deduction_option', __('Deduction Options')) }}<span class="text-danger">*</span>
                    {{ Form::select('deduction_option',$deduction_options,null, array('class' => 'form-control select2','required'=>'required')) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('title', __('Title')) }}
                    {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('amount', __('Amount')) }}
                    {{ Form::number('amount',null, array('class' => 'form-control ','required'=>'required','step'=>'0.01')) }}
                </div>
            </div>
            <div class="col-12">
                <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
                <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
            </div>
        </div>
    </div>
    {{Form::close()}}
</div>
<script>
      $(function () {
        $('input[type="text').keypress(function (e) {
			var regex = new RegExp("^[a-zA-Z]+$");
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