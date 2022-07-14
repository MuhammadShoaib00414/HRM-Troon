<div class="card bg-none card-box">
{{Form::open(array('url'=>'opd-payment','method'=>'post', 'enctype' => 'multipart/form-data'))}}
    <div class="row">
        <div class="form-group col-md-6">
        <label for="religion" class="form-control-label">{{ __('Employee') }}</label><span class="text-danger pl-1">*</span>
        <select class="form-control select2 select2-hidden-accessible"  name="employee_id" id="employee_id">
          
           @foreach($employee as $data)
      
             <option value="{{$data->id}}">{{$data->name}} </option>
           @endforeach 
        
        </select>
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
            {{ Form::number('amount',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{Form::label('date',__('Date'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
            {{Form::date('date',null,array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-md-6">
        {{Form::label('attachment',__('Attachment'),['class'=>'form-control-label'])}}

        <div class="choose-file form-group">
            
            <label for="attachment">
               <div>{{__('Choose File')}}</div>
               <input class="form-control border-0"  type="file" id="attachment" name="attachment" data-filename="attachment_filename">
               <p class="attachment_filename"></p>
           </label>
            

                </div>
        </div>
        </div>
        
        <div class="form-group col-md-12">
            {{Form::label('description',__('Description'))}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Note')))}}
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
    </div>
