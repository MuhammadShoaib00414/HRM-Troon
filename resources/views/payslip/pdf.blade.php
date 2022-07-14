@php
    $logo=asset(url('/public/storage/uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
@endphp

<div class="card bg-none card-box">


    <div class="invoice" id="printableArea">
        <div class="row">
            <div class="col-md-6">
                <div class="invoice-number">
                    <img src="{{$logo.'/'.(isset($company_logo) && !empty($company_logo)?$company_logo:'logo.png')}}"
                         width="170px;">
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-md-right mb-2">
                    <a href="#" class="btn btn-xs rounded-pill btn-warning" onclick="saveAsPDF()"><span
                                class="fa fa-download"></span></a>
                    <a title="Mail Send" href="{{route('payslip.send',[$employee->id,$payslip->salary_month])}}"
                       class="btn btn-xs rounded-pill btn-primary"><span class="fa fa-paper-plane"></span></a>
                </div>
            </div>
        </div>
        <div class="invoice-print">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6 class="mb-3">{{__('Salary Slip')}}</h6>

                    <address>
                        <strong>{{__('Employee Name')}} :</strong> {{$employee->fname}} {{$employee->lname}}<br>
                        <strong>{{__('Desigantion')}} :</strong> {{__('Employee')}}<br>
                        <strong>{{__('Salary Date')}} :</strong> {{\Auth::user()->dateFormat( $payslip->created_at)}}
                        <br>

                    </address>

                </div>

            </div>
        </div>


        <div class="row">

            <div class="table-responsive" id="full_width">
                <table class="table table-striped table-bordered table-hover table-md">
                    <tbody>
                    <tr>
                        <td colspan="2"><strong>Earning</strong></td>
                        <td colspan="2"><strong>Deduction</strong></td>
                    </tr>
                    <tr>
                        <td>{{__('Basic Salary')}}</td>
                        <td>{{  \Auth::user()->priceFormat( $payslip->basic_salary)}}</td>
                        @foreach($payslipDetail['deduction']['loan'] as $loan)
                            <td>{{$loan->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $loan->amount)}}</td>
                        @endforeach
                    </tr>
                    @foreach($payslipDetail['earning']['allowance'] as $allowance)
                        <tr>
                            <td>{{$allowance->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $allowance->amount)}}</td>

                    @endforeach
                    @foreach($payslipDetail['deduction']['deduction'] as $deduction)


                            <td>{{$deduction->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $deduction->amount)}}</td>
                        </tr>
                    @endforeach
                    @foreach($payslipDetail['earning']['commission'] as $commission)
                        <tr>

                            <td>{{$commission->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $commission->amount)}}</td>

                    @endforeach
                    @foreach($payslipDetail['deduction']['provident'] as $loan)


                            <td>{{$loan->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $loan->employee_amount)}}</td>
                        </tr>
                    @endforeach
                    @foreach($payslipDetail['earning']['otherPayment'] as $otherPayment)
                        <tr>

                            <td>{{$otherPayment->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $otherPayment->amount)}}</td>

                    @endforeach

                    @foreach($payslipDetail['deduction']['taxDeduction'] as $tax)


                            <td>{{$tax->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $tax->tax_amount)}}</td>
                        </tr>
                    @endforeach
                    @foreach($payslipDetail['earning']['overTime'] as $overTime)
                        <tr>

                            <td>{{$overTime->title}}</td>
                            <td>{{  \Auth::user()->priceFormat( $overTime->amount)}}</td>

                    @endforeach
                    @foreach($payslipDetail['deduction']['eobis'] as $eobi)


                           <td>{{$eobi->title}}</td>
                            <td>{{  \Auth::user()->priceFormat($eobi->employee_amount)}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td> <strong>{{__('Total Earning')}}</strong></td>
                        <td><strong> {{ \Auth::user()->priceFormat($payslipDetail['totalEarning'])}} </strong></td>
                        <td><strong>{{__('Total Deduction')}}</strong></td>
                        <td> <strong>{{ \Auth::user()->priceFormat($payslipDetail['totalDeduction'])}}</strong></td>

                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td ><strong class="final_style">{{__('Final Salary')}}</strong></td>
                        <td ><strong class="final_style">{{ (\Auth::user()->priceFormat($payslipDetail['totalEarning']-$payslipDetail['totalDeduction']))}}</strong></td>

                    </tr>
                    <tr>
                        <td colspan="2">Employee Signature ---------------------</td>
                        <td colspan="2"> {{__('Paid By')}}
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <span><img src="/public/upload/signature.png" width="50px;"></span>
                        </td>

                    </tr>
                    </tbody>


                </table>

            </div>

        </div>

    </div>

</div>
<script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script>

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: '{{$employee->name}}',
            image: {type: 'jpeg', quality: 1},
            html2canvas: {scale: 4, dpi: 72, letterRendering: true},
            jsPDF: {unit: 'in', format: 'A4'}
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
