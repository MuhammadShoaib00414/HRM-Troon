<div class="card bg-none card-box">
    {{Form::open(array('url'=>'appraisal','method'=>'post'))}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('branch',__('Branch'),['class'=>'form-control-label'])}}
                {{Form::select('branch',$brances,null,array('class'=>'form-control select2','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('employee',__('Employee'),['class'=>'form-control-label'])}}
                <select class="select2 form-control select2-multiple" id="employee" name="employee" data-toggle="select2" data-placeholder="{{ __('Select Employee') }}" required>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('appraisal_date',__('Select Month'),['class'=>'form-control-label'])}}
                {{ Form::text('appraisal_date','', array('class' => 'form-control custom-datepicker')) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('remark',__('Remarks'),['class'=>'form-control-label'])}}
                {{Form::textarea('remark',null,array('class'=>'form-control'))}}
            </div>
        </div>
    </div>

    @foreach($performance as $performances)

    <div class="row">
        <div class="col-md-12 mt-3">
            <h6>{{$performances->name}}</h6>
            <hr class="mt-0">
        </div>
        @foreach($performances->types as $types )
            <div class="col-6">
                {{$types->name}}
            </div>
            <div class="col-6">
                <fieldset id='demo1' class="rating">
                    <input class="stars" type="radio" id="technical-5-{{$types->id}}" name="rating[{{$types->id}}]" value="5"/>
                    <label class="full" for="technical-5-{{$types->id}}" title="Awesome - 5 stars"></label>
                    <input class="stars" type="radio" id="technical-4-{{$types->id}}" name="rating[{{$types->id}}]" value="4"/>
                    <label class="full" for="technical-4-{{$types->id}}" title="Pretty good - 4 stars"></label>
                    <input class="stars" type="radio" id="technical-3-{{$types->id}}" name="rating[{{$types->id}}]" value="3"/>
                    <label class="full" for="technical-3-{{$types->id}}" title="Meh - 3 stars"></label>
                    <input class="stars" type="radio" id="technical-2-{{$types->id}}" name="rating[{{$types->id}}]" value="2"/>
                    <label class="full" for="technical-2-{{$types->id}}" title="Kinda bad - 2 stars"></label>
                    <input class="stars" type="radio" id="technical-1-{{$types->id}}" name="rating[{{$types->id}}]" value="1"/>
                    <label class="full" for="technical-1-{{$types->id}}" title="Sucks big time - 1 star"></label>
                </fieldset>
            </div>
        @endforeach
    </div>
    @endforeach

{{--    <div class="row">--}}
{{--        <div class="col-md-12 mt-3">--}}
{{--            <h6>{{__('Organizational Competencies')}}</h6>--}}
{{--            <hr class="mt-0">--}}
{{--        </div>--}}
{{--        @foreach($organizationals as $organizational )--}}
{{--            <div class="col-6">--}}
{{--                {{$organizational->name}}--}}
{{--            </div>--}}
{{--            <div class="col-6">--}}
{{--                <fieldset id='demo1' class="rating">--}}
{{--                    <input class="stars" type="radio" id="organizational-5-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="5"/>--}}
{{--                    <label class="full" for="organizational-5-{{$organizational->id}}" title="Awesome - 5 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-4-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="4"/>--}}
{{--                    <label class="full" for="organizational-4-{{$organizational->id}}" title="Pretty good - 4 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-3-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="3"/>--}}
{{--                    <label class="full" for="organizational-3-{{$organizational->id}}" title="Meh - 3 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-2-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="2"/>--}}
{{--                    <label class="full" for="organizational-2-{{$organizational->id}}" title="Kinda bad - 2 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-1-{{$organizational->id}}" name="rating[{{$organizational->id}}]" value="1"/>--}}
{{--                    <label class="full" for="organizational-1-{{$organizational->id}}" title="Sucks big time - 1 star"></label>--}}
{{--                </fieldset>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12 mt-3">--}}
{{--            <h6>{{__('Behaviourals Competencies')}}</h6>--}}
{{--            <hr class="mt-0">--}}
{{--        </div>--}}
{{--        @foreach($behaviourals as $behavioural )--}}
{{--            <div class="col-6">--}}
{{--                {{$behavioural->name}}--}}
{{--            </div>--}}
{{--            <div class="col-6">--}}
{{--                <fieldset id='demo1' class="rating">--}}
{{--                    <input class="stars" type="radio" id="organizational-5-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="5"/>--}}
{{--                    <label class="full" for="organizational-5-{{$behavioural->id}}" title="Awesome - 5 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-4-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="4"/>--}}
{{--                    <label class="full" for="organizational-4-{{$behavioural->id}}" title="Pretty good - 4 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-3-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="3"/>--}}
{{--                    <label class="full" for="organizational-3-{{$behavioural->id}}" title="Meh - 3 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-2-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="2"/>--}}
{{--                    <label class="full" for="organizational-2-{{$behavioural->id}}" title="Kinda bad - 2 stars"></label>--}}
{{--                    <input class="stars" type="radio" id="organizational-1-{{$behavioural->id}}" name="rating[{{$behavioural->id}}]" value="1"/>--}}
{{--                    <label class="full" for="organizational-1-{{$behavioural->id}}" title="Sucks big time - 1 star"></label>--}}
{{--                </fieldset>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}


    <div class="row">

        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
