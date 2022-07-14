@extends('layouts.admin')
@section('page-title')
    {{__('OPD Payment Detail Page')}}
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
                        title: filename
                    },
                    {
                        extend: 'excel',
                        title: filename
                    }, {
                        extend: 'csv',
                        title: filename
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
        <div class="col-xl-2 col-lg-2">
            {{ Form::open(array('route' => array('report.leave'),'method'=>'get','id'=>'report_leave')) }}
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
        <div class="col-xl-3 col-lg-3 month">
            <div class="all-select-box">
                <div class="btn-box">
                    {{Form::label('month',__('Month'),['class'=>'text-type'])}}
                    {{Form::month('month',isset($_GET['month'])?$_GET['month']:date('Y-m'),array('class'=>'month-btn form-control'))}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 year d-none">
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
            <a href="{{url('opd-payment')}}" class="reset-btn" data-toggle="tooltip" data-original-title="{{__('Reset')}}">
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
                                <th>{{__('Month')}}</th>
                                <th>{{__('Employee')}}</th>
                                <th>{{__('Subscription amount')}}</th>
                                <th>{{__('Contribution  amount')}}</th>
                                <th>{{__('Withdraw PF')}}</th>
                                <th>{{__('Balance PF')}}</th>
                                <!-- <th>{{__('Date')}}</th> -->
                                <!-- <th>{{__('Acction')}}</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($providentFound as $providentFund)

                                <tr>
                                    <td><strong>{{$providentFund['month_name']}}</strong></td>
                                    <td>{{$providentFund['employee_name']}}</td>
                                    <td>{{$providentFund['employee_amount']}}</td>
                                    <td>{{$providentFund['employer_amout']}}</td>
                                   
                                 


                                    @if($providentFund['month_name'] === $providentFund['request_month_name'])
                                    <td>{{$providentFund['amount']}}</td>
                                   @else
                                   <td>----</td> 
                                   @endif
                                    
                                    <!-- <td>{{$providentFund['employee_amount'] + $providentFund['employer_amout']}}</td>  -->
                                    @if($providentFund['month_name'] == $providentFund['request_month_name'])
                                    <td>{{$providentFund['employee_amount'] + $providentFund['employer_amout'] - $providentFund['amount']}}</td> 
                                   @else
                                   <td>{{$providentFund['employee_amount'] + $providentFund['employer_amout']}}</td> 
                                   @endif
                                    <!-- <td>{{$providentFund['employee_date']}}</td> -->
                                   
                                
                            @endforeach
                            
                            </tbody>
                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

