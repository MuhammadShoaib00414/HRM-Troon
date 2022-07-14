
<div class="card bg-none card-box">
{{Form::model($eobi,array('route' => array('eobi.update', $eobi->id), 'method' => 'PUT')) }}
    @csrf
    {{ Form::hidden('employee_id',$eobi->id, array()) }}
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('title', __('Title'),['class'=>'form-control-label']) }}<span class="text-danger">*</span>
            {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6">
            {{ Form::label('employee_amount', __('EOBI Amount'),['class'=>'form-control-label']) }}<span class="text-danger">*</span>
            {{ Form::number('employee_amount',null, array('class' => 'form-control ','required'=>'required')) }}
            <input type="hidden" name="eobi_id" value="{{$eobi->id}}">
        </div>

        <div class="form-group col-md-6">
            {{ Form::label('employer_amount', __('Employer Amount'),['class'=>'form-control-label']) }}<span class="text-danger">*</span>
            {{ Form::number('employer_amount',null, array('class' => 'form-control ','required'=>'required')) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('eobi_date', __('EOBI Date'),['class'=>'form-control-label']) }}
            {{ Form::date('eobi_date',null, array('class' => 'form-control','required'=>'required')) }}
        </div>
       
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
