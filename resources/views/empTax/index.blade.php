@extends('layouts.admin')
@section('page-title')
    {{__('Employee Tax')}}
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
            {{ Form::open(array('url' => array('employee-tax'),'method'=>'get','id'=>'report_leave')) }}
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
        <div class="col-xl-5 col-lg-3 month">
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
      
        <div class="col-auto my-custom">
            <a href="#" class="apply-btn" onclick="document.getElementById('report_leave').submit(); return false;" data-toggle="tooltip" data-original-title="{{__('apply')}}">
                <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
            </a>
            <a href="{{url('employee-tax')}}" class="reset-btn" data-toggle="tooltip" data-original-title="{{__('Reset')}}">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>

        </div>
    </div>
    {{ Form::close() }}
@endsection

@section('content')
    <div id="printableArea" class="mt-4">
       
    </div>

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
                                <th>{{__('Tax Amount')}}</th>
                                <th>{{__('Date')}}</th>
                              
                                <th>{{__('Acction')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($emplTaxs as $emplTax)
                                <tr>
                                    <td>{{ \Auth::user()->employeeIdFormat($emplTax['employee_id']) }}</td>
                                    <td>{{$emplTax['name']}}</td>
                                    <td>{{$emplTax['tax_amount']}}</td>
                                    <td>{{\Auth::user()->dateFormat($emplTax['date'])}}</td>
                                    <td>
                                      <a href="{{ route('employee.tax.details',$emplTax['employee_id']) }}" data-size="lg" data-ajax-popup="true" data-title="View Employee Tax" class="edit-icon" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-eye"></i></a>
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

