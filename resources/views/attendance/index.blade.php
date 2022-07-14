@extends('layouts.admin')
@section('page-title')
    {{__('Manage Attendance List')}}
@endsection
@push('script-page')
    <script>
        $('input[name="type"]:radio').on('change', function (e) {
            var type = $(this).val();

            if (type == 'monthly') {
                $('.month').addClass('d-block');
                $('.month').removeClass('d-none');
                $('.date').addClass('d-none');
                $('.date').removeClass('d-block');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            } else if(type == 'daily') {
                $('.date').addClass('d-block');
                $('.date').removeClass('d-none');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            }else{

                $('.year').addClass('d-block');
                $('.year').removeClass('d-none');
                $('.date').addClass('d-none');
                $('.date').removeClass('d-block');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
            }
        });

        $('input[name="type"]:radio:checked').trigger('change');

    </script>
@endpush
@section('action-button')
    <div class="row d-flex justify-content-end">
      <div class="col-auto">
          {{ Form::open(array('route' => array('attendanceemployee.index'),'method'=>'get','id'=>'attendanceemployee_filter')) }}
      </div>
      <div class="col-4">
        <div class="all-select-box">
            <div class="btn-box">
                <label class="text-type">{{__('Type')}}</label> <br>
                <div class="d-flex radio-check">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="monthly" value="monthly" name="type" class="custom-control-input" {{isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'}}>
                        <label class="custom-control-label" for="monthly">{{__('Monthly')}}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="daily" value="daily" name="type" class="custom-control-input" {{isset($_GET['type']) && $_GET['type']=='daily' ?'checked':''}}>
                        <label class="custom-control-label" for="daily">{{__('Daily')}}</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="year" value="year" name="type" class="custom-control-input" {{isset($_GET['type']) && $_GET['type']=='year' ?'checked':''}}>
                        <label class="custom-control-label" for="year">{{__('Year')}}</label>
                    </div>
                </div>
            </div>
          </div>
      </div>
      <div class="col-auto month">
        <div class="all-select-box">
            <div class="btn-box">
                {{Form::label('month',__('Month'),['class'=>'text-type'])}}
                {{Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control month-btn'))}}
            </div>
        </div>
      </div>
      <div class="col-4 date">
        <div class="all-select-box">
            <div class="btn-box">
                {{ Form::label('date', __('Date'),['class'=>'text-type'])}}
                {{ Form::text('date',isset($_GET['date'])?$_GET['date']:'', array('class' => 'form-control datepicker month-btn')) }}
            </div>
        </div>
      </div>

        <div class="col-4 year">
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('year', __('Year'),['class'=>'text-type'])}}
                    <select class="form-control select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                        @foreach($filterYear as $data)
                            <?php $year =  date('Y', strtotime($data['date']));?>
                            <option {{ ($year) == date("Y") ? 'selected' : '' }} value="{{$year}}">
                                {{$year}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
{{--      @if(\Auth::user()->type != 'employee')--}}
{{--          <div class="col-2">--}}
{{--              <div class="all-select-box">--}}
{{--                  <div class="btn-box">--}}
{{--                      {{ Form::label('branch', __('Branch'),['class'=>'text-type'])}}--}}
{{--                      {{ Form::select('branch', $branch,isset($_GET['branch'])?$_GET['branch']:'', array('class' => 'form-control select2')) }}--}}
{{--                  </div>--}}
{{--              </div>--}}
{{--          </div>--}}
{{--          <div class="col-2">--}}
{{--              <div class="all-select-box">--}}
{{--                  <div class="btn-box">--}}
{{--                      {{ Form::label('department', __('Department'),['class'=>'text-type'])}}--}}
{{--                      {{ Form::select('department', $department,isset($_GET['department'])?$_GET['department']:'', array('class' => 'form-control select2')) }}--}}
{{--                  </div>--}}
{{--              </div>--}}
{{--          </div>--}}
{{--      @endif--}}
      <div class="col-auto  my-custom">
          <a href="#" class="apply-btn" onclick="document.getElementById('attendanceemployee_filter').submit(); return false;">
              <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
          </a>
          <a href="{{route('attendanceemployee.index')}}" class="reset-btn">
              <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
          </a>
      </div>
    {{ Form::close() }}
  </div>
@endsection
@section('content')
    <br><br>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body py-0">
               
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 dataTable">
                            <thead>
                            <tr>
                                <th>{{__('Employee ID')}}</th>

                            @if(\Auth::user()->type!='employee')
                                    <th>{{__('Employee')}}</th>
                                @endif
                                <th>{{__('Date')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Time')}}</th>
                                <!-- <th>{{__('Clock Out')}}</th> -->
                                <th>{{__('Type')}}</th>
                                <th>{{__('Late')}}</th>
{{--                                <th>{{__('Early Leaving')}}</th>--}}
{{--                                    <th>{{__('Overtime')}}</th>--}}
                                @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                    <th>{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($getAllemployeeAttandanceData as $att)

                                   @php
                                   $time1 = strtotime('11:15');  // 2012-12-06 23:56
                                   $time2 = strtotime($att['clock_in']);  // 2012-12-06 00:21
                                   $late =  ($time1 - $time2)/60;


                                   $minutes =  $late;
                                   $zero    = new DateTime('@0');
                                   $offset  = new DateTime('@' . $minutes * 60);
                                   $diff    = $zero->diff($offset);
                                   $total_late = $diff->format('%h Hours, %i Minutes');

                                 @endphp  
                                 <tr>
                                     <td>{{ $att['employee_id'] }}</td>
                                     <td><?php echo(isset($getUser[$att['employee_id']]) ? $getUser[$att['employee_id']]['name'] : $att['employee_id']); ?></td>
                                    <td>{{ \Auth::user()->dateFormat($att['date']) }}</td>
                                    <td>{{ $att['status'] }}</td>
                                    <td>{{ ($att['clock_in'] !='00:00:00') ?\Auth::user()->timeFormat($att['clock_in']):'00:00' }} </td>
                                     <!-- @if($att['type'] == 0)
                                         <td>{{ ($att['clock_in'] !='00:00:00') ?\Auth::user()->timeFormat($att['clock_in']):'00:00' }} </td>

                                     @else
                                        <td> ----------</td>
                                     @endif -->
                                     <td>
                                         @if($att['type'] == 1)
                                             {{'Check Out'}}
                                         @else
                                             {{'Check In'}}
                                         @endif
                                     </td>
                                     <td>
                                         @if($att['type'] == 0)
                                             {{ $total_late}}
                                         @else
                                           ----------
                                         @endif


                                         </td>
{{--                                     @if($att['type'] == 0)--}}
{{--                                        @php $clock_in = $att['clock_in']; @endphp--}}
{{--                                     @else--}}
{{--                                         @php $check_out = $att['clock_in']; @endphp--}}
{{--                                     @endif--}}
{{--                                      {{ round(abs($clock_in - $check_out) / 3600,2)}}--}}
{{--                                     <td>{{$clock_in  }}</td>--}}


                                    @if(Gate::check('edit attendance') || Gate::check('delete attendance'))
                                        <td>
{{--                                            @can('edit attendance')--}}
{{--                                                <a href="#" data-url="{{ URL::to('attendanceemployee/'.$att['id'].'/edit') }}" data-size="lg" data-ajax-popup="true" data-title="{{__('Edit Attendance')}}" class="edit-icon" data-toggle="tooltip" data-original-title="{{__('Edit')}}"><i class="fas fa-pencil-alt"></i></a>--}}
{{--                                            @endcan--}}
                                            @can('delete attendance')
                                                <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$att['id']}}').submit();"><i class="fas fa-trash"></i></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['attendanceemployee.destroy', $att['id']],'id'=>'delete-form-'.$att['id']]) !!}
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                    @endif
                                </tr>

                           @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        $(document).ready(function () {
            $('.daterangepicker').daterangepicker({
                format: 'yyyy-mm-dd',
                locale: {format: 'YYYY-MM-DD'},
            });
        });
        function postDataAttandance() {
            $.ajax({
                url: '{{route('attendanceemployee.addAttandanceFromMachine')}}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    // console.log(data);
                },
                error: function (data) {

                }
            });
        }
        setInterval(function(){
            postDataAttandance();
        }, 60 * 1000);
    </script>
@endpush
