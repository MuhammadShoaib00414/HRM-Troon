<div class="card bg-none card-box">
{{Form::open(array('url'=>'storeAllocatedAmount','method'=>'post', 'enctype' => 'multipart/form-data'))}}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('set_total_opd', __('Total OPD Amount Set'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
            {{ Form::number('set_total_opd',null, array('class' => 'form-control','required'=>'required')) }}
        </div> <div class="form-group col-md-12">
            {{ Form::label('set_total_employee_opd', __('Total OPD Employee Amount Set'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
            {{ Form::number('set_total_employee_opd',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{Form::label('date',__('Date'),['class'=>'form-control-label'])}}<span class="text-danger pl-1">*</span>
            {{Form::date('year',null,array('class'=>'form-control'))}}
        </div>
           
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
    </div>
