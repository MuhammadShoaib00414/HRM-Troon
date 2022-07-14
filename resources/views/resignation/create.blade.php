<div class="card bg-none card-box">
    {{Form::open(array('url'=>'resignation','method'=>'post','enctype' => 'multipart/form-data'))}}
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
                <option value="yes"> Yes  </option>
                <option value="no"> No  </option>
               
            </select>
        </div>

        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('notice_date',__('Disable Account'),['class'=>'form-control-label'])}}
            <select class="form-control select2 select2-hidden-accessible" name="disabledAccount" id="disabledAccount">
            <option value="" selected="" disabled="">Select One</option>
                <option value="yes"> Yes  </option>
                <option value="no"> No </option>
               
            </select>
        </div>
        

        <div class="form-group col-lg-6"  id="items">
            <div class="choose-file form-group">
                <label for="document">
                    <div>{{__('Choose File')}}</div>
                    <input class="form-control border-0" type="file" id="resignationDocument" name="resignationDocument[]"  data-filename="letter_filename"> 

                    <p class="letter_filename"></p>
                </label>
            </div>
        </div>

       <div class="form-group col-md-12">
       
          <a href="#"  id="add" class="btn add-more btn-create badge-blue uppercase" >
                <i class="fa fa-plus"></i> Add
            </a>

            <a class="delete btn btn-create badge-danger uppercase" >
               - Remove
            </a>
     </div>
        
       
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class'=>'form-control-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','placeholder'=>__('Enter Description')))}}
        </div>
        <div class="col-12">
            <input type="submit" value="{{__('Create')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>

<script>
$(document).ready(function() {
  $(".delete").hide();
  //when the Add Field button is clicked
  $("#add").click(function(e) {
    $(".delete").fadeIn("1500");
    //Append a new row of code to the "#items" div
    $("#items").append(
      '<div class="next-referral form-group col-lg-6"><div class="choose-file form-group" ><label for="document"><div>{{__('Choose File')}}</div><input class="form-control border-0" type="file" id="degree_copy" name="resignationDocument[]"  data-filename="letter_filenames">    <p class="letter_filenames"></p> </label></div></div');
  });
  $("body").on("click", ".delete", function(e) {
    $(".next-referral").last().remove();
  });
});


</script>