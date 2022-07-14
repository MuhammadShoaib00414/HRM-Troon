<div class="card bg-none card-box">
    {{Form::model($resignation,array('route' => array('resignation.update', $resignation->id), 'method' => 'PUT','enctype' => 'multipart/form-data')) }}
    <div class="row">
        @if(\Auth::user()->type!='employee')
            <div class="form-group col-lg-12">
                {{ Form::label('employee_id', __('Employee'),['class'=>'form-control-label'])}}
                {{ Form::select('employee_id', $employees,null, array('class' => 'form-control select2','required'=>'required')) }}
              
            </div>
        @endif
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('notice_date',__('Notice Date'),['class'=>'form-control-label'])}}
            {{Form::text('notice_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('resignation_date',__('Resignation Date'),['class'=>'form-control-label'])}}
            {{Form::text('resignation_date',null,array('class'=>'form-control datepicker'))}}
        </div>
        
        
        
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('notice_date',__('Exit Interview'),['class'=>'form-control-label'])}}
            <select class="form-control select2 select2-hidden-accessible" name="exit_interview" id="exit_interview">
                <option value="" selected="" disabled="" >Select One</option>
                <option value="yes"  {{ ($resignation['exit_interview']) == 'yes' ? 'selected' : '' }}> Yes  </option>
                <option value="no"  {{ ($resignation['exit_interview']) == 'no' ? 'selected' : '' }}> No  </option>
               
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('notice_date',__('Disable Account'),['class'=>'form-control-label'])}}
            <select class="form-control select2 select2-hidden-accessible" name="disabledAccount" id="disabledAccount">
            <option value="" selected="" disabled="">Select One</option>
                <option value="yes"  {{ ($resignation['disabledAccount']) == 'yes' ? 'selected' : '' }}> Yes  </option>
                <option value="no"  {{ ($resignation['disabledAccount']) == 'no' ? 'selected' : '' }}> No </option>
               
            </select>
        </div>
        

        <div class="form-group col-lg-12">
            <?php
                $resignation = json_decode($resignation['resignationDocument']);
                
                ?>
            <table class="table table-bordered" id="dynamicDevice">
                <td>
                    <button type="button" name="device_add" id="add_device" class="btn-create btn-xs badge-blue radius-10px">Add More</button>
                </td>
                @foreach($resignation as $file)
                <tr>
                    <td class="form-group">
                        <div class="choose-file form-group">
                        <label for="document">
                            <div>{{__('Choose File')}}</div>
                            <input class="form-control border-0" type="file" id="resignationDocument" value="{{$file}}" name="resignationDocument[]" data-filename="profile_filenames">   
                            <input class="form-control" type="hidden" value="{{$file}}" name="resignation_old[]">   
                            <p class="profile_filenames"></p>
                        </label>
                        </div>
                    </td>
                    <td>
                     @if($file)
                        <a href="/public/uploads/resignation/{{$file}}" download><i class="fa fa-download"></i></a>
                     @endif
                    </td>
                    <td><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td>
                </tr>
                </tr>
                @endforeach 
            </table>
         </div>
        
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class'=>'form-control-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
<script>

var i = 0;
$("#add_device").click(function() {
		++i;
		$("#dynamicDevice").append('<tr> <td class="form-group"> <div class="choose-file form-group"> <label for="document"> <div>{{__('Choose File')}}</div><input class="form-control border-0" type="file" id="resignationDocument" name="resignationDocument[]"> </label> </div></td><td></td><td><button type="button" class="btn-create btn-xs badge-danger radius-10px float-right remove-tr">Remove</button></td></tr></tr>');
	});
    $(document).on('click', '.remove-tr', function() {
		$(this).parents('tr').remove();
	});


</script>