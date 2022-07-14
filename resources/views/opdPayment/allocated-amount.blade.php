@extends('layouts.admin')

@section('page-title')
    {{__('Allocated Amount')}}
@endsection
@section('action-button')
    <div class="row d-flex justify-content-end">
    <div class="col-xl-4 col-lg-2">
            {{ Form::open(array('url' => array('allocated-amount'),'method'=>'get','id'=>'report_leave')) }}
            <div class="all-select-box">
                <div class="btn-box">
                  
                    <div class="d-flex radio-check">
                       
                        <div class="custom-control custom-radio custom-control-inline">
                            <input style="display:none" type="radio" id="yearly" value="yearly" name="type" class="custom-control-input yearly" {{isset($_GET['type']) && $_GET['type']=='yearly' ?'checked':'checked'}}>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <div class="col-xl-5 col-lg-3">
            <div class="all-select-box">
                <div class="btn-box">
                    {{ Form::label('year', __('Year'),['class'=>'text-type']) }}
                    <select class="form-control select2" id="year" name="year" tabindex="-1" aria-hidden="true">
                      @foreach($filterYear as $data)  
                        <?php $year =  date('Y', strtotime($data['year']));?>                  
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
            <a href="{{url('allocated-amount')}}" class="reset-btn" data-toggle="tooltip" data-original-title="{{__('Reset')}}">
                <span class="btn-inner--icon"><i class="fas fa-trash-restore-alt"></i></span>
            </a>

            <a href="#" data-url="{{ url('create-allocated-amount') }}" class="btn btn-xs btn-white btn-icon-only width-auto"
               data-ajax-popup="true" data-title="{{__('Create Allocated Amount')}}">
                <i class="fa fa-plus"></i> {{__('Create')}}
            </a>
        </div>
    </div>
    {{ Form::close() }}
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

 

@section('content')

<div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-4">
                    <table class="table table-striped mb-0" id="report-dataTable">
                            <thead>
                            <tr>
                                <th>{{__('ID')}}</th>
                                <th>{{__('Set Range')}}</th>
                                <th>{{__('Set Employee Range')}}</th>
                                <th>{{__('Year')}}</th>
                                <th>{{__('Acction')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($allocatedAmounts as $allocatedAmount)
                        
                            <tr>
                                    <td>{{ \Auth::user()->employeeIdFormat($allocatedAmount['id']) }}</td>
                                    <td>{{!empty($allocatedAmount['set_total_opd']) ? \Auth::user()->priceFormat($allocatedAmount['set_total_opd']) : '-';}}</td>
                                    <td>{{!empty($allocatedAmount['set_total_employee_opd']) ? \Auth::user()->priceFormat($allocatedAmount['set_total_employee_opd']) : '-';}}</td>
                                    <td>{{\Auth::user()->dateFormat($allocatedAmount['year'])}}</td>
                                    <td>
                                  
                                    <a href="#" class="delete-icon" data-toggle="tooltip" data-original-title="{{__('Delete')}}" 
                                      data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}"
                                       data-confirm-yes="document.getElementById('delete-form-{{$allocatedAmount['id']}}').submit();"><i class="fas fa-trash"></i></a>
                                      {!! Form::open(['method' => 'DELETE', 'url' => ['allocated-amount/destroyAllocatedAmount', $allocatedAmount['id']],'id'=>'delete-form-'.$allocatedAmount['id']]) !!}
                                      {!! Form::close() !!}                                
                                    </td>
                                 </tr>                              
                            @endforeach
                            
                            </tbody>
                        @if($grandTotalAmount)
                            <tbody>

                            <tr>
                                <th><strong>{{__('Grand Total')}} </strong></th>
                                <td> <strong> {{$grandTotalAmount}}</strong></td>
                                <td> <strong> {{$setTotalEmployeeOpd}}</strong></td>
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
