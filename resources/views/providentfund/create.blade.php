<div class="card bg-none card-box">
{{Form::open(array('url'=>'request-provident','method'=>'post'))}}
    <div class="row">
        <div class="form-group col-md-4">
        <label for="religion" class="form-control-label">{{ __('Employee') }}</label>
        <select class="form-control select2 select2-hidden-accessible"  name="employee_id" id="employee_id">
          
           @foreach($employee as $data)
      
             <option value="{{$data->id}}">{{$data->name}} </option>
           @endforeach 
        
        </select>
        </div>
        <div class="form-group col-md-4 ">
            {{ Form::label('amount', __('Amount'),['class'=>'form-control-label'])}}
            {{ Form::number('amount',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-4">
            {{Form::label('date',__('Date'),['class'=>'form-control-label'])}}
            {{Form::date('date',null,array('class'=>'form-control'))}}
        </div>
       
        <div class="form-group col-md-12">
            {{Form::label('note',__('Description'))}}
            {{Form::textarea('note',null,array('class'=>'form-control','placeholder'=>__('Enter Note')))}}
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
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