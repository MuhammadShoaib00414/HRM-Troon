@extends('layouts.admin')

@section('page-title')
    {{__('Provident Fund withdrawal')}}
@endsection
@push('script-page')

    <script type="text/javascript" src="{{ asset('js/jszip.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pdfmake.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/buttons.html5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var filename = $('#filename').val();

        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };
            html2pdf().set(opt).from(element).save();

        }

        $(document).ready(function () {
            var filename = $('#filename').val();
            $('#report-dataTable').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'pdf',
                        text: '<a  class="view-btn blue-bg">PDF</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3],
                            targets: 1,
                            className: 'italic'
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<a  class="view-btn blue-bg">Excel</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3],
                            targets: 1,
                            className: 'italic'
                        }
                    }, {
                        extend: 'csv',
                        text: '<a  class="view-btn blue-bg">CSV</a>',
                        title: filename,
                        exportOptions: {
                            columns: [0,1,2,3],
                            targets: 1,
                            className: 'italic'
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        $('input[name="type"]:radio').on('change', function (e) {
            var type = $(this).val();
            if (type == 'monthly') {
                $('.month').addClass('d-block');
                $('.month').removeClass('d-none');
                $('.year').addClass('d-none');
                $('.year').removeClass('d-block');
            } else {
                $('.year').addClass('d-block');
                $('.year').removeClass('d-none');
                $('.month').addClass('d-none');
                $('.month').removeClass('d-block');
            }
        });

        $('input[name="type"]:radio:checked').trigger('change');

    </script>
@endpush
@section('action-button')
    <div class="row d-flex justify-content-end">
        <div class="col-xl-4 col-lg-2">
            {{ Form::open(array('url' => array('request-provident'),'method'=>'get','id'=>'report_leave')) }}
            <div class="all-select-box">
                <div class="btn-box">
                    <label class="text-type">{{__('Type')}}</label> <br>
                    <div class="d-flex radio-check">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="monthly" value="monthly" name="type" class="custom-control-input monthly" {{isset($_GET['type']) && $_GET['type']=='monthly' ?'checked':'checked'}}>
                            <label class="custom-control-label" for="monthly">{{__('Monthly')}}</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="yearly" value="yearly" name="type" class="custom-control-input yearly" {{isset($_GET['type']) && $_GET['type']=='yearly' ?'checked':''}}>
                            <label class="custom-control-label" for="yearly">{{__('Yearly')}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-3 month d-block">
            <div class="all-select-box">
                <div class="btn-box">
                    {{Form::label('month',__('Month'),['class'=>'text-type'])}}
                    {{Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control'))}}
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-3 year d-none">
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('year', __('Year'),['class'=>'text-type']) }}
                    <select class="form-control select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                        @for($filterYear['starting_year']; $filterYear['starting_year'] <= $filterYear['ending_year']; $filterYear['starting_year']++)
                            <option {{(isset($_GET['year']) && $_GET['year'] == $filterYear['starting_year'] ?'selected':'')}} {{(!isset($_GET['year']) && date('Y') == $filterYear['starting_year'] ?'selected':'')}} value="{{$filterYear['starting_year']}}">{{$filterYear['starting_year']}}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_leave').submit(); return false;" data-toggle="tooltip" data-original-title="{{__('apply')}}">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="{{url('report-provident-found')}}" class="reset-btn" data-toggle="tooltip" data-original-title="{{__('Reset')}}">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>
        
            <a href="#" data-url="{{ route('request-provident.create') }}" class="btn btn-xs btn-white btn-icon-only width-auto" 
            data-ajax-popup="true" data-title="{{__('Create New Request')}}">
             <i class="fa fa-plus"></i> {{__('Create')}}
         </a>
        </div>
    </div>
    {{ Form::close() }}
@endsection

 

@section('content')
<div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-4">
                        <table class="table table-striped mb-0" id="report-dataTable">
                            <thead>
                            <tr>
                                <th>{{__('Employee ID')}}</th>
                                <th>{{__('Employee')}}</th>
                                <th>{{__('Employee amount')}}</th>
                                <th>{{__('Date')}}</th>
                              
                                <th>{{__('Acction')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($providetStatus as $providentFound)

                                <tr>
                                    <td>{{ \Auth::user()->employeeIdFormat($providentFound['employee_id']) }}</td>
                                    <td>{{$providentFound['name']}}</td>
                                    <td>{{$providentFound['amount']}}</td>
                                    <td>{{$providentFound['date']}}</td>
                                  
                                    <td>
                                 
{{--                                      <a href="#" data-size="lg" data-ajax-popup="true" data-title="Edit Allowance" class="edit-icon" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-eye"></i></a>--}}
                                      <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" 
                                      data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"
                                       data-confirm-yes="document.getElementById('delete-form-{{$providentFound['id']}}').submit();"><i class="fas fa-trash"></i></a>
                                      {!! Form::open(['method' => 'DELETE', 'route' => ['request-provident.destroy', $providentFound['id']],'id'=>'delete-form-'.$providentFound['id']]) !!}
                                                {!! Form::close() !!}                                
                                    </td>

                            @endforeach
                            
                            </tbody>
                            @if($grandTotal)
                                <tbody>
                                <tr>
                                    <th><strong>{{__('Grand Total')}} </strong></th>
                                    <td></td>
                                    <td> <strong> {{$grandTotal}}</strong></td>
                                </tr>
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
