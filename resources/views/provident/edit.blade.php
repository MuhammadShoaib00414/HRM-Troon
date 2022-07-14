<div class="card bg-none card-box">
    {{Form::model($provident,array('route' => array('provident.update', $provident->id), 'method' => 'PUT')) }}
    <div class="card-body p-0">
        <div class="row">
            <div class="form-group  col-md-12">
                {{ Form::label('title', __('Title'),['class'=>'form-control-label']) }} <span class="text-danger"> *</span>
                {{ Form::text('title',null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        <div class="form-group col-md-6">
            {{ Form::label('employee_amount', __('Employee Amount'),['class'=>'form-control-label']) }}<span class="text-danger"> *</span>
            {{ Form::number('employee_amount',null, array('class' => 'form-control ','required'=>'required')) }}
            <input type="hidden" name="provident_id" value="{{$provident->id}}">
        </div>
      
        <div class="form-group  col-md-6">
              {{ Form::label('employee_date', __('Start Date'),['class'=>'form-control-label']) }} <span class="text-danger"> *</span>
              {{ Form::date('employee_date',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
                <div class="form-group  col-md-6">
                    {{ Form::label('employer_amout', __('Employer Amout'),['class'=>'form-control-label']) }}<span class="text-danger"> *</span>
                    {{ Form::number('employer_amout',null, array('class' => 'form-control','required'=>'required')) }}
                </div>   
            <div class="form-group  col-md-6">
                    {{ Form::label('employer_date', __('Employer Date'),['class'=>'form-control-label']) }}<span class="text-danger"> *</span>
                    {{ Form::date('employer_date',null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    
    {{Form::close()}}

</div>
