@extends('layouts.admin')
@section('page-title')
    {{__('Payslip List')}}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-header">
                <div class="card">
                @if(!request()->start_month)
                    <div class="card-header">
                        <form>
                            <div class="d-flex justify-content-between w-100 align-items-center">
                                <h6>{{__('Find Employee Payslip')}}</h6>
                                <div class="float-right col-4">
                                    <select class="form-control month_date select2" name="year" tabindex="-1" aria-hidden="true">
                                        <option value="--">--</option>
                                        @foreach($month as $k=>$mon)
                                            <option value="{{$k}}">{{$mon}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="float-right col-3">
                                <select class="form-control year_date select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                      
                                    @foreach($years as $data)         
                                        <option {{ ($data) == date("Y") ? 'selected' : '' }} value="{{$data}}">
                                            {{$data}}
                                                </option>
                                     @endforeach
                            </select>
                                </div>

                            </div>
                        </form>
                
                    </div>
                    @endif  
                   <br>
                
                       
                    <div class="row d-flex ">
                        <div class="card-header">
{{--                    <h6>{{__('Employee Payslip Search For PDF')}}</h6>--}}
                    </div>
                            <div class="col-md-3">
                                {{ Form::open(array('url' => array('payslip-list'),'method'=>'get','id'=>'report_account')) }}
                                <div class="all-select-box">
                                    <div class="btn-box">
                                        <strong>{{Form::label('start_month',__('Start Month'),['class'=>'text-type'])}}</strong>
                                        {{Form::month('start_month',isset($_GET['start_month'])?$_GET['start_month']:date('Y-m'),array('class'=>'month-btn form-control'))}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="all-select-box">
                                    <div class="btn-box">
                                      <strong>  {{Form::label('end_month',__('End Month'),['class'=>'text-type'])}}</strong>
                                      {{Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:date('Y-m'),array('class'=>'month-btn form-control'))}}
                                  
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-md-3">
                                <div class="all-select-box">
                                    <div class="btn-box">
                                      <strong>  {{Form::label('select employee',__('Select Employee'),['class'=>'text-type'])}}</strong>
                                        <!-- {{Form::month('end_month',isset($_GET['end_month'])?$_GET['end_month']:date('Y-m', strtotime("-5 month")),array('class'=>'month-btn form-control'))}} -->
                                        <select class="form-control select2" id="employee" name="employee" tabindex="-1" aria-hidden="true">
                                            <option value="">-- Select Employee --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <br>
                                <a href="#" class="apply-btn" onclick="document.getElementById('report_account').submit(); return false;" data-toggle="tooltip" data-original-title="{{__('apply')}}">
                                    <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                                </a>
                                <a href="{{url('payslip-list')}}" class="reset-btn" data-toggle="tooltip" data-original-title="{{__('Reset')}}">
                                    <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
                                </a>
                                @if(request()->start_month)
                                <!-- <a href="#" data-url="http://demo-hrm.com/payslip/pdf/2/2022-01" data-size="md-pdf" data-ajax-popup="true" class="view-btn yellow-bg" data-title="Employee Payslip">Payslip</a> -->
                               <form mathed="post">
                                <a  data-url="{{ url('payslip/pdfGenerate') }}" data-size="md-pdf"  data-ajax-popup="true" class="action-btn" data-title="{{__('View Payslip ')}}"><i class="fas fa-eye"></i></a>
                                <input type="hidden" value="{{Request::fullUrl() }}" name="fullUrl">
                                @endif
                            </form>
                                <!-- <a href="#" class="action-btn" onclick="saveAsPDF()" data-toggle="tooltip" data-original-title="{{__('Download')}}">
                                    <span class="btn-inner--icon"><i class="fas fa-download"></i></span>
                                </a> -->
                            </div>
                            {{ Form::close() }}
                        </div>
                    <div class="card-body">
                        <div class="table-responsive py-4">
                            <table class="table table-striped mb-0" id="dataTable1">
                                <thead>
                                <tr>
                                    <th>{{__('Id')}}</th>
                                    <th>{{__('ACCOUNTNUMBER')}}</th>
                                    <th>{{__('BENEFICIARY NAME')}}</th>
                                    <th>{{__('CONSUMERNUMBERREFERENCE')}}</th>
                                    <th>{{__('Basic Salary') }}</th>
                                    <th>{{__('Allowance') }}</th>
                                    <th>{{__('Commission') }}</th>
                                    <th>{{__('Other Payment') }}</th>
                                    <th>{{__('Over Time') }}</th>
                                    <th>{{__('Net Salary') }}</th>
                                    <th>{{__('Saturation  Deduction')}}</th>
                                    <th>{{__('Loan')}}</th>
                                    <th>{{__('Provident Funds')}}</th>
                                    <th>{{__('Tax Dedutcion')}}</th>
                                    <th>{{__('EOBI Amount')}}</th>
                                    <th>{{__('TRANSAMOUNT')}}</th>
                                    <th>{{__('Status') }}</th>
                                    <th>{{__('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script type="text/javascript">
        $(document).ready(function () {
            var filename = 'Download  (IFT)';
            var sammry = 'Summary of Salary';
            var table = $('#dataTable1').DataTable({
                dom: 'lBfrtip',
                fixedColumns: true,
                buttons: [
                    {
                        extend: 'excel',
                        title: filename,
                        text: '<a  class="view-btn green-bg">Download (IFT)</a>',
                        exportOptions: {
                            columns: [1,2,3,15],
                            targets: 1,
                            className: 'italic'
                        }
                    },
                    {
                        extend: 'excel',
                        title: sammry,
                        text: '<a class="view-btn green-bg">Summary of Salary</a>',
                        exportOptions: {
                            columns: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16],
                            targets: 1,
                            className: 'italic'
                        }
                    },
                ],

                select: true,
                "aoColumnDefs": [
                    {
                        "aTargets": [16],
                        "mData": null,
                        "mRender": function (data, type, full) {
                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;
                            var id = data[0];

                            if (data[16] == 'Paid')
                                return '<div class="badge badge-pill badge-success"><a href="#" class="text-white">' + data[16] + '</a></div>';
                            else
                                return '<div class="badge badge-pill badge-danger"><a href="#" class="text-white">' + data[16] + '</a></div>';
                        }
                    },
                    {
                        "aTargets": [17],
                        "mData": null,
                        "mRender": function (data, type, full) {

                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var datePicker = year + '-' + month;

                            var id = data[0];
                            var payslip_id = data[17];

                            var clickToPaid = '';
                            var payslip = '';
                            var view = '';
                            var edit = '';
                            var deleted = '';
                            var form = '';

                            // if (data[17] != 0) {
                            //     var payslip = '<a href="#" data-url="{{ url('payslip/pdf/') }}/' + id + '/' + datePicker + '" data-size="md-pdf"  data-ajax-popup="true" class="view-btn yellow-bg" data-title="{{__('Employee Payslip')}}">' + '{{__('Payslip')}}' + '</a> ';
                            // }

                            // if (data[16] == "UnPaid" && data[17] != 0) {
                            //     clickToPaid = '<a  data_i="'+ id +'" data_id="{{ url('payslip/paysalary/') }}/' + id + '/' + datePicker + '"  class="view-btn clickToPaid green-bg">' + '{{__('Click To Paid')}}' + '</a>  ';
                            // }

                            // if (data[17] != 0) {
                            //     view = '<a href="#" data-url="{{ url('payslip/showemployee/') }}/' + payslip_id + '"  data-ajax-popup="true" class="view-btn gray-bg" data-title="{{__('View Employee Detail')}}">' + '{{__('View')}}' + '</a>';
                            // }

                            // if (data[17] != 0 && data[16] == "UnPaid") {
                            //     edit = '<a href="#" data-url="{{ url('payslip/editemployee/') }}/' + payslip_id + '"  data-ajax-popup="true" class="view-btn blue-bg" data-title="{{__('Edit Employee salary')}}">' + '{{__('Edit')}}' + '</a>';
                            // }

                            var url = '{{ route("payslip.delete", ":id") }}';
                            url = url.replace(':id', payslip_id);

                            if (data[17] != 0) {
                                deleted = '<a href="#"  data-url="' + url + '" class="payslip_delete view-btn red-bg" >' + '{{__('Delete')}}' + '</a>';

                            }


                            return view + payslip + clickToPaid + edit + deleted + form;
                        }
                    },
                ]
            });

            function callbackfOrEmployuee() {
                $.ajax({
                    url: '{{route('payslip.allemployee')}}',
                    type: 'POST',
                    data: {
                         "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        console.log(data);
                        if(data)
                        {
                            var ele = document.getElementById('employee');
                            for (var i = 0; i < data.length; i++) {
                                // POPULATE SELECT ELEMENT WITH JSON.
                                ele.innerHTML = ele.innerHTML +
                                    '<option value="' + data[i]['id'] + '">' + data[i]['name'] + '</option>';
                            }
                        }
            
                    },
                    error: function (data) {

                    }
                });
            }
            $( document ).ready(function() {
                callbackfOrEmployuee();
            });

            

            function callback() {
               
                var sPageURL =  window.location.href;
                // var sPageURL = window.location.search.substring();


                var month = $(".month_date").val();
               
                var year = $(".year_date").val();
                var datePicker = year + '-' + month;
               
              
                $.ajax({
                    url: '{{route('payslips.search_json_list')}}',
                    type: 'POST',
                    data: {
                        "datePicker": datePicker,"month": month,"sPageURL": sPageURL, "_token": "{{ csrf_token() }}",
                    },
                    success: function (data) {
                        // console.log(data);
                        table.rows().remove().draw();
                        table.rows.add(data).draw();
                        table.column(0).visible(false);
                        $('[data-toggle="tooltip"]').tooltip();

                        if (!(data)) {
                            show_toastr('error', 'Payslip Not Found!', 'error');
                        }
                    },
                    error: function (data) {

                    }
                });
            }
            $( document ).ready(function() {
                callback();
            });

            $(document).on("change", ".month_date,.year_date", function () {
                callback();
            });

            //bulkpayment Click
            $(document).on("click", "#bulk_payment", function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '_' + month;

            });
            $(document).on('click', '#bulk_payment', 'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]', function () {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '-' + month;

                var title = 'Bulk Payment';
                var size = 'md';
                var url = 'payslip/bulk_pay_create/' + datePicker;


                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $.ajax({
                    url: url,
                    success: function (data) {
                        if (data.length) {
                            $('#commonModal .modal-body').html(data);
                            $("#commonModal").modal('show');
                        } else {
                            show_toastr('Error', 'Permission denied.');
                            $("#commonModal").modal('hide');
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('Error', data.error);
                    }
                });
            });

            $(document).on("click", ".payslip_delete", function () {
                var confirmation = confirm("are you sure you want to delete this payslip?");
                var url = $(this).data('url');
                if (confirmation) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function (data) {

                            show_toastr('Success', 'Payslip successfully deleted', 'success');

                            setTimeout(function () {
                                location.reload();
                            }, 800)


                        },

                    });

                }
            });

        });


    </script>
@endpush
@push('script-page')

    <script type="text/javascript" src="{{ asset('js/jszip.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/pdfmake.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.buttons.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/buttons.html5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/multiselect/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/multiselect/dataTables.buttons.min.js') }}"></script>


    <script type="text/javascript" src="{{ asset('js/multiselect/buttons.html5.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/multiselect/dataTables.select.min.js') }}"></script>



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


    </script>
@endpush