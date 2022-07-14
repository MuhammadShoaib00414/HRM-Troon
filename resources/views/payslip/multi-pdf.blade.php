@php
    $logo=asset(url('/public/storage/uploads/logo/'));
    $company_logo=Utility::getValByName('company_logo');
      $url = $_SERVER['HTTP_REFERER'];
        parse_str( parse_url( $url, PHP_URL_QUERY), $array );
        $startDate = $array['start_month'];
        $endDate = $array['end_month'];

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

                </div>
            </div>
        </div>
        <div class="invoice-print">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h6 class="mb-3">{{__('Salary Slip')}}</h6>


                    <address>
                        <strong>{{__('Employee Name')}} :</strong> {{$payslip[0]['employee_user']['fname']}} {{$payslip[0]['employee_user']['lname']}}<br>
                        <strong>{{__('Desigantion')}} :</strong> {{__('Employee')}}<br>
                        <strong>{{__('CNIC')}} :</strong> {{$payslip[0]['employee_user']['cnic']}}<br>
                        <strong>{{__('Salary Date')}} :</strong>
                        {{\Auth::user()->dateFormat($startDate)}} To {{\Auth::user()->dateFormat($endDate)}}
                    </address>

                </div>

            </div>
        </div>

        <div class="row">

            <div class="table-responsive" id="full_width">
                <table class="table table-striped table-bordered table-hover table-md">
                    <tbody>
                    @foreach($payslipDetail['earning']['allowance'] as $allowances)
                        <tr class="font-weight-bold text-center border-none">
                            <th colspan="4"><h2>
                                        <strong> {{ \Carbon\Carbon::parse($allowances['salary_month'])->format('F,d,Y') }} </strong>
                                   </h2>
                        </tr>

                        <tr>
                            <td colspan="2"><strong>Earning</strong></td>
                            <td colspan="2"><strong>Deduction</strong></td>
                        </tr>
                        <tr>
                            <td>{{__('Basic Salary')}}</td>
                            <td> {{\Auth::user()->priceFormat($payslip[0]['basic_salary'])}} </td>
                            @foreach(json_decode($allowances['loan']) as $loan)
                                <td> {{ $loan->title }}</td>
                                <td> {{  \Auth::user()->priceFormat($loan->amount) }}</td>
                            @endforeach

                        </tr>
                        <tr>
                            @foreach(json_decode($allowances['allowance']) as $allowance)
                                <td> {{ $allowance->title }}</td>
                                <td> {{  \Auth::user()->priceFormat($allowance->amount) }}</td>

                            @endforeach

                            @foreach(json_decode($allowances['saturation_deduction']) as $saturation_deduction)
                                <td>------------</td>
                                <td> {{  \Auth::user()->priceFormat($saturation_deduction->amount) }}</td>
                            @endforeach


                        </tr>
                        <tr>
                            @foreach($payslipDetail['earning']['commission'] as $commission)
                                <td> {{ $commission['title'] }}</td>
                                <td> {{  \Auth::user()->priceFormat($commission['amount']) }}</td>
                            @endforeach
                            @foreach(json_decode($allowances['provident']) as $provident)

                                <td>------------</td>
                                <td> {{  \Auth::user()->priceFormat($provident->employer_amout) }}</td>
                            @endforeach
                        </tr>

                        <tr>
                            @foreach($payslipDetail['earning']['otherPayment'] as $other_payment)
                                <td> {{ $other_payment['title'] }}</td>
                                <td> {{  \Auth::user()->priceFormat($other_payment['amount']) }}</td>
                            @endforeach
                            @foreach(json_decode($allowances['tax']) as $taxDeduction)
                                <td>------------</td>
                                <td> {{  \Auth::user()->priceFormat($taxDeduction->tax_amount) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($payslipDetail['earning']['overTime'] as $overtime)
                                <td> {{ $overtime['title'] }}</td>
                                <td> {{  \Auth::user()->priceFormat($payslipDetail['earning']['overTime'][0]['amount']) }}</td>
                            @endforeach
                            @foreach(json_decode($allowances['eobi']) as $eobi)
                                <td>------------</td>
                                <td> {{  \Auth::user()->priceFormat($eobi->employee_amount) }}</td>
                            @endforeach
                        </tr>
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
                    @endforeach


                    </tbody>


                </table>

            </div>
        </div>
    </div>


            </tbody>
            </table>


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
