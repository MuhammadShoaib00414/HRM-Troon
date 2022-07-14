<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Commission;
use App\Models\Employee;
use App\Models\Provident;
use App\Models\Loan;
use App\Models\TaxDeduction;
use App\Models\EOBI;
use Carbon\Carbon;
use App\Models\Mail\PayslipSend;
use App\Models\OtherPayment;
use App\Models\Overtime;
use App\Models\PaySlip;
use App\Models\SaturationDeduction;
use App\Models\ProvidentFound;
use App\Models\EmployeeEOBI;
use App\Models\Utility;
use App\Models\EmployeeTax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use DB;
class PaySlipController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage pay slip') || \Auth::user()->type != 'client' || \Auth::user()->type != 'company')
        {
            $employees = Employee::where(
                [
                    'created_by' => \Auth::user()->creatorId(),
                ]
            )->first();

            $month = [
                '01' => 'JAN',
                '02' => 'FEB',
                '03' => 'MAR',
                '04' => 'APR',
                '05' => 'MAY',
                '06' => 'JUN',
                '07' => 'JUL',
                '08' => 'AUG',
                '09' => 'SEP',
                '10' => 'OCT',
                '11' => 'NOV',
                '12' => 'DEC',
            ];
                
                // DB::enableQueryLog();
            $years_get = PaySlip::select('employee_id',
                'salary_month'
            )
                 ->groupBy('salary_month')
                ->get()
                ->toArray();
             // dd(DB::getQueryLog());
             
                 $years = [];
                    foreach($years_get as $key => $name) {
                     
                        $years[$key] =  date('Y', strtotime($name['salary_month']));
                     }
                    $years = array_unique($years);
              
            return view('payslip.index', compact('employees', 'month','years'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function payslipList()
    {
        if(\Auth::user()->can('manage pay slip') || \Auth::user()->type != 'client' || \Auth::user()->type != 'company')
        {
            $employees = Employee::where(
                [
                    'created_by' => \Auth::user()->creatorId(),
                ]
            )->first();

            $month = [
                '01' => 'JAN',
                '02' => 'FEB',
                '03' => 'MAR',
                '04' => 'APR',
                '05' => 'MAY',
                '06' => 'JUN',
                '07' => 'JUL',
                '08' => 'AUG',
                '09' => 'SEP',
                '10' => 'OCT',
                '11' => 'NOV',
                '12' => 'DEC',
            ];

            $years_get = PaySlip::select('employee_id',
                'salary_month'
            )
                 ->groupBy('salary_month')
                ->get()
                ->toArray();
             // dd(DB::getQueryLog());
             
                 $years = [];
                    foreach($years_get as $key => $name) {
                     
                        $years[$key] =  date('Y', strtotime($name['salary_month']));
                     }
                    $years = array_unique($years);

            return view('payslip.payslip-list', compact('employees', 'month', 'years'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function search_json_list(Request $request)
    {

        $url =$request->sPageURL;
       
        parse_str( parse_url( $url, PHP_URL_QUERY), $array );
        if(!empty($array)) {
            $startDate = $array['start_month'];
            $endDate = $array['end_month'];
            $formate_month_year = $array['employee'];
            $paylip_employee = PaySlip::select(
                [
                    'employees.id',
                    'employees.employee_id',
                    'employees.name',
                    'pay_slips.salary_month',
                    'employees.account_number',
                    'pay_slips.commission',
                    'pay_slips.allowance',
                    'payslip_types.name as payroll_type',
                    'pay_slips.basic_salary',
                    'pay_slips.net_payble',
                    'pay_slips.id as pay_slip_id',
                    'pay_slips.status',
                    'employees.user_id',
                ]
            )->leftjoin(
                'employees', function ($join) use ($formate_month_year) {
                $join->on('employees.id', '=', 'pay_slips.employee_id');
                $join->on('pay_slips.employee_id', '=', \DB::raw("'" . $formate_month_year . "'"));
                $join->leftjoin('payslip_types', 'payslip_types.id', '=', 'employees.salary_type');
            }
            )
                ->where('pay_slips.salary_month', '>=',$startDate)
                ->where('pay_slips.salary_month', '<=', $endDate)
                ->where('employees.created_by', \Auth::user()->creatorId())
               ->get();

            $salary_month = 0;
            foreach ($paylip_employee as $employee) {
                $allowances = Allowance::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'allowances.employee_id', '=', 'employees.id')->get();
                $total_allowance = 0;
                foreach ($allowances as $allowance) {
                    $total_allowance = $allowance->amount + $total_allowance;
                }
                // commison
                $commissions = Commission::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'commissions.employee_id', '=', 'employees.id')->get();
                $total_commission = 0;
                foreach ($commissions as $commission) {
                    $total_commission = $commission->amount + $total_commission;
                }
                //OtherPayment
                $other_payments = OtherPayment::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'other_payments.employee_id', '=', 'employees.id')->get();
                $total_other_payment = 0;
                foreach ($other_payments as $other_payment) {
                    $total_other_payment = $other_payment->amount + $total_other_payment;
                }
                //Overtime
                $over_times = Overtime::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'overtimes.employee_id', '=', 'employees.id')->get();
                $total_over_time = 0;
                foreach ($over_times as $over_time) {
                    $total_work = $over_time->number_of_days * $over_time->hours;
                    $amount = $total_work * $over_time->rate;
                    $total_over_time = $amount + $total_over_time;
                }
                //Saturation Deduction
                $saturation_deductions = SaturationDeduction::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'saturation_deductions.employee_id', '=', 'employees.id')->get();
                $total_saturation_deduction = 0;
                foreach ($saturation_deductions as $saturation_deduction) {
                    $total_saturation_deduction = $saturation_deduction->amount + $total_saturation_deduction;
                }
                //Loan
                $loans = Loan::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'loans.employee_id', '=', 'employees.id')->get();
                $total_loan = 0;
                foreach ($loans as $loan) {
                    $total_loan = $loan->amount + $total_loan;
                }
                // provident found
                $providents = Provident::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'providents.employee_id', '=', 'employees.id')->get();
                $total_provident_payment = 0;
                foreach ($providents as $provident_payment) {
                    $total_provident_payment = $provident_payment->employee_amount + $total_provident_payment;

                }
                // tax
                $taxDeduction = TaxDeduction::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'tax_deductions.employee_id', '=', 'employees.id')->get();
                $total_taxDeduction = 0;
                foreach ($taxDeduction as $other_payment) {
                    $total_taxDeduction = $other_payment->tax_amount + $total_taxDeduction;
                }
                //EOBI
                $eobis = EOBI::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees', 'e_o_b_i_s.employee_id', '=', 'employees.id')->get();

                $total_eobi_payment = 0;
                foreach ($eobis as $eobi_payment) {
                    $total_eobi_payment = $eobi_payment->employee_amount + $total_eobi_payment;
                }
                if (Auth::user()->type == 'employee') {
                    if (Auth::user()->id == $employee->user_id) {
                        $tmp = [];
                        $tmp[] = $employee->id;
                        $tmp[] = $employee->name;
                        $tmp[] = substr($employee->account_number, -10);
                        $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                        $tmp[] = $total_allowance;
                        $tmp[] = $employee->pay_slip_id;
                        $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                        $tmp[] = !empty($employee->net_payble) ? \Auth::user()->priceFormat($employee->net_payble) : '-';
                        if ($employee->status == 1) {
                            $tmp[] = 'paid';
                        } else {
                            $tmp[] = 'unpaid';
                        }
                        $tmp[] = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                        $data[] = $tmp;
                    }
                } else {
                    // dd(date('F'));
                    $tmp = [];
                    $tmp[] = $employee->id;
                    $tmp[] = substr($employee->account_number, -10);
                    $tmp[] = $employee->name;
                    $tmp[] = date('M' . '.') . '00' . $employee->id;
                    $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                    $tmp[] = $total_allowance;
                    $tmp[] = $total_commission;
                    $tmp[] = $total_other_payment;
                    $tmp[] = $total_over_time;
                    $tmp[] = !empty($employee->basic_salary) ? ($employee->basic_salary + $total_allowance + $total_commission + $total_other_payment + $total_over_time) : '-';
                    //  priceFormat($employee->basic_salary+$total_allowance + $total_commission + $total_other_payment + $total_over_time);
                    $total_basic_salary = $employee->basic_salary + $total_allowance + $total_commission + $total_other_payment + $total_over_time;
                    // $tmp[] = !empty($employee->net_payble) ? \Auth::user()->priceFormat($employee->net_payble) : '-';
                    $tmp[] = $total_saturation_deduction;
                    $tmp[] = $total_loan;
                    $tmp[] = $total_provident_payment;
                    $tmp[] = $total_taxDeduction;
                    $tmp[] = $total_eobi_payment;
                    $tmp[] = !empty($employee->basic_salary) ? ($total_basic_salary - $total_saturation_deduction - $total_loan - $total_provident_payment - $total_taxDeduction - $total_eobi_payment) : '-';
                    if ($employee->status == 1) {
                        $tmp[] = 'Paid';
                    } else {
                        $tmp[] = 'UnPaid';
                    }
                    $tmp[] = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                    $data[] = $tmp;
                }

            }
                return $data;

        }else{
        $formate_month_year = $request->datePicker;
        if($formate_month_year == "2022---") {
            $formate_month_year = explode('--', $formate_month_year);
          
            $formate_month_year = $formate_month_year[0].'-'.date('m');
        
        }else{
                $formate_month_year;
         }
    //    DB::enableQueryLog();
        $validatePaysilp    = PaySlip::where('salary_month','=' , $formate_month_year)->get()->toarray();
//    dd($validatePaysilp);
        // $query = DB::getQueryLog();
        // $query = end($query);
        if(empty($validatePaysilp))
        {
            return;
        }
        else
        {
//        DB::enableQueryLog();
            $paylip_employee = PaySlip::select(
                [
                    'employees.id',
                    'employees.employee_id',
                    'employees.name',
                    'employees.account_number',
                    'pay_slips.commission',
                    'pay_slips.allowance',
                    'payslip_types.name as payroll_type',
                    'pay_slips.basic_salary',
                    'pay_slips.net_payble',
                    'pay_slips.id as pay_slip_id',
                    'pay_slips.status',
                    'employees.user_id',
                ]
            )->leftjoin(
                'employees', function ($join) use ($formate_month_year){
                $join->on('employees.id', '=', 'pay_slips.employee_id');
                $join->on('pay_slips.salary_month', '=', \DB::raw("'" . $formate_month_year . "'"));
                $join->leftjoin('payslip_types', 'payslip_types.id', '=', 'employees.salary_type');
            }
            )->where('employees.created_by', \Auth::user()->creatorId())->get();
//        $query = DB::getQueryLog();
//        $query = end($query);
//            dd($query);
            $salary_month = 0;
            foreach($paylip_employee as $employee)
            {
                $allowances      = Allowance::where('employees.employee_id', '=',$employee->employee_id)
                    ->leftjoin('employees','allowances.employee_id' , '=','employees.id')->get();
                $total_allowance = 0;
                foreach($allowances as $allowance)
                {
                    $total_allowance = $allowance->amount + $total_allowance;
                }
                // commison
                $commissions      =   Commission::where('employees.employee_id', '=',$employee->employee_id)
                    ->leftjoin('employees','commissions.employee_id' , '=','employees.id')->get();
                $total_commission = 0;
                foreach($commissions as $commission)
                {
                    $total_commission = $commission->amount + $total_commission;
                }
                //OtherPayment
                $other_payments      = OtherPayment::where('employees.employee_id', '=',$employee->employee_id)
                    ->leftjoin('employees','other_payments.employee_id' , '=','employees.id')->get();
                $total_other_payment = 0;
                foreach($other_payments as $other_payment)
                {
                    $total_other_payment = $other_payment->amount + $total_other_payment;
                }
                //Overtime
                $over_times      = Overtime::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','overtimes.employee_id' , '=','employees.id')->get();
                $total_over_time = 0;
                foreach($over_times as $over_time)
                {
                    $total_work      = $over_time->number_of_days * $over_time->hours;
                    $amount          = $total_work * $over_time->rate;
                    $total_over_time = $amount + $total_over_time;
                }
                //Saturation Deduction
                $saturation_deductions      = SaturationDeduction::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','saturation_deductions.employee_id' , '=','employees.id')->get();
                $total_saturation_deduction = 0;
                foreach($saturation_deductions as $saturation_deduction)
                {
                    $total_saturation_deduction = $saturation_deduction->amount + $total_saturation_deduction;
                }
                //Loan
                $loans  = Loan::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','loans.employee_id' , '=','employees.id')->get();
                $total_loan = 0;
                foreach($loans as $loan)
                {
                    $total_loan = $loan->amount + $total_loan;
                }
                // provident found
                $providents   = Provident::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','providents.employee_id' , '=','employees.id')->get();
                $total_provident_payment = 0;
                foreach($providents as $provident_payment)
                {
                    $total_provident_payment = $provident_payment->employee_amount + $total_provident_payment;

                }
                // tax
                $taxDeduction   = TaxDeduction::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','tax_deductions.employee_id' , '=','employees.id')->get();
                $total_taxDeduction = 0;
                foreach($taxDeduction as $other_payment)
                {
                    $total_taxDeduction = $other_payment->tax_amount + $total_taxDeduction;
                }
                //EOBI
                $eobis  = EOBI::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','e_o_b_i_s.employee_id' , '=','employees.id')->get();

                $total_eobi_payment = 0;
                foreach($eobis as $eobi_payment)
                {
                    $total_eobi_payment = $eobi_payment->employee_amount + $total_eobi_payment;
                }
                if(Auth::user()->type == 'employee')
                {
                    if(Auth::user()->id == $employee->user_id)
                    {
                        $tmp   = [];
                        $tmp[] = $employee->id;
                        $tmp[] = $employee->name;
                        $tmp[] = substr($employee->account_number, -10);
                        $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                        $tmp[] = $total_allowance;
                        $tmp[] = $employee->pay_slip_id;
                        $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                        $tmp[] = !empty($employee->net_payble) ? \Auth::user()->priceFormat($employee->net_payble) : '-';
                        if($employee->status == 1)
                        {
                            $tmp[] = 'paid';
                        }
                        else
                        {
                            $tmp[] = 'unpaid';
                        }
                        $tmp[]  = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                        $data[] = $tmp;
                    }
                }
                else
                {
                    // dd(date('F'));
                    $tmp   = [];
                    $tmp[] = $employee->id;
                    $tmp[] = substr($employee->account_number, -10);
                    $tmp[] = $employee->name;
                    $tmp[] =  date('M'.'.').'00'.$employee->id;
                    $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                    $tmp[] = $total_allowance;
                    $tmp[] = $total_commission;
                    $tmp[] = $total_other_payment;
                    $tmp[] = $total_over_time;
                    $tmp[] = !empty($employee->basic_salary) ? ($employee->basic_salary+$total_allowance + $total_commission + $total_other_payment + $total_over_time) : '-';
                    //  priceFormat($employee->basic_salary+$total_allowance + $total_commission + $total_other_payment + $total_over_time);
                    $total_basic_salary = $employee->basic_salary+$total_allowance + $total_commission + $total_other_payment + $total_over_time;
                    // $tmp[] = !empty($employee->net_payble) ? \Auth::user()->priceFormat($employee->net_payble) : '-';
                    $tmp[] = $total_saturation_deduction;
                    $tmp[] = $total_loan;
                    $tmp[] = $total_provident_payment;
                    $tmp[] = $total_taxDeduction;
                    $tmp[] = $total_eobi_payment;
                    $tmp[] = !empty($employee->basic_salary) ? ($total_basic_salary-$total_saturation_deduction-$total_loan-$total_provident_payment- $total_taxDeduction-$total_eobi_payment) : '-';
                    if($employee->status == 1)
                    {
                        $tmp[] = 'Paid';
                    }
                    else
                    {
                        $tmp[] = 'UnPaid';
                    }
                    $tmp[]  = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                    $data[] = $tmp;
                }

            }

            return $data;
        }
        }
    }

    public function getAllEmployee()
    {
        $employee  = Employee::select(
            [
                'employees.id',
                'employees.name'
                
            ]
            )->where('employees.created_by', \Auth::user()->creatorId())->get();

            return response()->json($employee);
            // return $employee;
    }

 
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        

        $validator = \Validator::make(
            $request->all(), [
//                               'month' => 'required',
//                               'year' => 'required',

                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

//        $month = $request->month;
//        $year  = $request->year;
        $formate_month_year  = $request->month;
// dd( $formate_month_year );
        $year = date('Y', strtotime($formate_month_year));
        $month = date('m', strtotime($formate_month_year));

//        $formate_month_year = $year . '-' . $month;

        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->where('created_by', \Auth::user()->creatorId())->pluck('employee_id');
        $payslip_employee   = Employee::where('created_by', \Auth::user()->creatorId())->where('company_doj', '<=', date($year . '-' . $month . '-t'))->where('status','active')->count();

        if($payslip_employee > count($validatePaysilp))
        {
            $employees = Employee::where('created_by', \Auth::user()->creatorId())->where('company_doj', '<=', date($year . '-' . $month . '-t'))->where('status','active')->whereNotIn('employee_id', $validatePaysilp)->get();

            $employeesSalary = Employee::where('created_by', \Auth::user()->creatorId())->where('salary', '<=', 0)->first();

            if(!empty($employeesSalary))
            {
                return redirect()->route('payslip.index')->with('error', __('Please set employee salary.'));
            }

            foreach($employees as $employee)
            {

                $payslipEmployee                       = new PaySlip();
                $payslipEmployee->employee_id          = $employee->id;
                $payslipEmployee->net_payble           = $employee->get_net_salary();
                $payslipEmployee->salary_month         = $formate_month_year;
                $payslipEmployee->status               = 0;
                $payslipEmployee->basic_salary         = !empty($employee->salary) ? $employee->salary : 0;
                $payslipEmployee->allowance            = Employee::allowance($employee->id);
                $payslipEmployee->commission           = Employee::commission($employee->id);
                $payslipEmployee->loan                 = Employee::loan($employee->id);
                $payslipEmployee->saturation_deduction = Employee::saturation_deduction($employee->id);
                $payslipEmployee->other_payment        = Employee::other_payment($employee->id);
                $payslipEmployee->overtime             = Employee::overtime($employee->id);
                $payslipEmployee->eobi                 = Employee::EOBI($employee->id);
                $payslipEmployee->tax                  = Employee::TAX($employee->id);
                $payslipEmployee->provident            = Employee::Provident($employee->id);
                $payslipEmployee->created_by           = \Auth::user()->creatorId();

                $payslipEmployee->save();

                //Slack Notification
                $setting  = Utility::settings(\Auth::user()->creatorId());
                if(isset($setting['payslip_notification']) && $setting['payslip_notification'] ==1){
                    $msg = __("Payslip generated of").' '.$formate_month_year.'.';
                    Utility::send_slack_msg($msg);
                }

                //Telegram Notification
                $setting  = Utility::settings(\Auth::user()->creatorId());
                if(isset($setting['telegram_payslip_notification']) && $setting['telegram_payslip_notification'] ==1){
                    $msg = __("Payslip generated of").' '.$formate_month_year.'.';
                    Utility::send_telegram_msg($msg);
                }
            }

            return redirect()->route('payslip.index')->with('success', __('Payslip successfully created.'));
        }
        else
        {
            return redirect()->route('payslip.index')->with('error', __('Payslip Already created.'));
        }

    }

    public function destroy($id)
    {
      
        $payslip = PaySlip::find($id);
        $payslip->delete();

        return true;
    }

    public function showemployee($paySlip)
    {
        $payslip = PaySlip::find($paySlip);
        
        return view('payslip.show', compact('payslip'));
    }


    public function search_json(Request $request)
    {
        
        $formate_month_year = $request->datePicker;
        $validatePaysilp    = PaySlip::where('salary_month', '=', $formate_month_year)->where('created_by', \Auth::user()->creatorId())->get()->toarray();
        if(empty($validatePaysilp))
        {
            return;
        }
        else
        {
            $paylip_employee = PaySlip::select(
                [
                    'employees.id',
                    'employees.employee_id',
                    'employees.name',
                    'employees.account_number',
                    'pay_slips.commission',
                    'pay_slips.allowance',
                    'payslip_types.name as payroll_type',
                    'pay_slips.basic_salary',
                    'pay_slips.net_payble',
                    'pay_slips.id as pay_slip_id',
                    'pay_slips.status',
                    'employees.user_id',
                ]
            )->leftjoin(
                'employees', function ($join) use ($formate_month_year){
                $join->on('employees.id', '=', 'pay_slips.employee_id');
                $join->on('pay_slips.salary_month', '=', \DB::raw("'" . $formate_month_year . "'"));
                $join->leftjoin('payslip_types', 'payslip_types.id', '=', 'employees.salary_type');
            }
            )->where('employees.created_by', \Auth::user()->creatorId())->get();
            $salary_month = 0;
            foreach($paylip_employee as $employee)
            {
                $allowances      = Allowance::where('employees.employee_id', '=',$employee->employee_id)
                    ->leftjoin('employees','allowances.employee_id' , '=','employees.id')->get();
                $total_allowance = 0;
                foreach($allowances as $allowance)
                {
                    $total_allowance = $allowance->amount + $total_allowance;
                }
                // commison
                $commissions      =   Commission::where('employees.employee_id', '=',$employee->employee_id)
                    ->leftjoin('employees','commissions.employee_id' , '=','employees.id')->get();
                $total_commission = 0;
                foreach($commissions as $commission)
                {
                    $total_commission = $commission->amount + $total_commission;
                }
                 //OtherPayment
                $other_payments      = OtherPayment::where('employees.employee_id', '=',$employee->employee_id)
                    ->leftjoin('employees','other_payments.employee_id' , '=','employees.id')->get();
                $total_other_payment = 0;
                foreach($other_payments as $other_payment)
                {
                    $total_other_payment = $other_payment->amount + $total_other_payment;
                }
                //Overtime
                $over_times      = Overtime::where('employees.employee_id', '=', $employee->employee_id)
                ->leftjoin('employees','overtimes.employee_id' , '=','employees.id')->get();
                $total_over_time = 0;
                foreach($over_times as $over_time)
                {
                    $total_work      = $over_time->number_of_days * $over_time->hours;
                    $amount          = $total_work * $over_time->rate;
                    $total_over_time = $amount + $total_over_time;
                }
                 //Saturation Deduction
                    $saturation_deductions      = SaturationDeduction::where('employees.employee_id', '=', $employee->employee_id)
                        ->leftjoin('employees','saturation_deductions.employee_id' , '=','employees.id')->get();
                    $total_saturation_deduction = 0;
                    foreach($saturation_deductions as $saturation_deduction)
                    {
                        $total_saturation_deduction = $saturation_deduction->amount + $total_saturation_deduction;
                    }
                //Loan
                    $loans  = Loan::where('employees.employee_id', '=', $employee->employee_id)
                        ->leftjoin('employees','loans.employee_id' , '=','employees.id')->get();
                    $total_loan = 0;
                    foreach($loans as $loan)
                    {
                        $total_loan = $loan->amount + $total_loan;
                    }
                // provident found
                $providents   = Provident::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','providents.employee_id' , '=','employees.id')->get();
                $total_provident_payment = 0;
                foreach($providents as $provident_payment)
                {
                    $total_provident_payment = $provident_payment->employee_amount + $total_provident_payment;
                   
                }
                // tax
                $taxDeduction   = TaxDeduction::where('employees.employee_id', '=', $employee->employee_id)
                    ->leftjoin('employees','tax_deductions.employee_id' , '=','employees.id')->get();
                $total_taxDeduction = 0;
                foreach($taxDeduction as $other_payment)
                {
                    $total_taxDeduction = $other_payment->tax_amount + $total_taxDeduction;
                }
               //EOBI
          
               $getCurrentDate  = explode('-',$request->datePicker);
  
                    $eobis  = EOBI::where('employees.employee_id', '=', $employee->employee_id)
                        ->leftjoin('employees','e_o_b_i_s.employee_id' , '=','employees.id')->whereMonth('e_o_b_i_s.eobi_date',$getCurrentDate[1])
                        ->whereYear('e_o_b_i_s.eobi_date',$getCurrentDate[0])->get();
                        $quries = DB::getQueryLog();

                    $total_eobi_payment = 0;
                    foreach($eobis as $eobi_payment)
                { 
                    $total_eobi_payment = $eobi_payment->employee_amount + $total_eobi_payment;
                }
                if(Auth::user()->type == 'employee')
                {
                    if(Auth::user()->id == $employee->user_id)
                    {
                        $tmp   = [];
                        $tmp[] = $employee->id;
                        $tmp[] = $employee->name;
                        $tmp[] = substr($employee->account_number, -10);
                        $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                        $tmp[] = $total_allowance;
                        $tmp[] = $employee->pay_slip_id;
                        $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                        $tmp[] = !empty($employee->net_payble) ? \Auth::user()->priceFormat($employee->net_payble) : '-';
                        if($employee->status == 1)
                        {
                            $tmp[] = 'paid';
                        }
                        else
                        {
                            $tmp[] = 'unpaid';
                        }
                        $tmp[]  = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                        $data[] = $tmp;
                    }
                }
                else
                {
                    // dd(date('F'));
                    $tmp   = [];
                    $tmp[] = $employee->id;
                    $tmp[] = substr($employee->account_number, -10);
                    $tmp[] = $employee->name;
                    $tmp[] =  date('M'.'.').'00'.$employee->id;
                    $tmp[] = !empty($employee->basic_salary) ? \Auth::user()->priceFormat($employee->basic_salary) : '-';
                    $tmp[] = $total_allowance;
                    $tmp[] = $total_commission;
                    $tmp[] = $total_other_payment;
                    $tmp[] = $total_over_time;
                    $tmp[] = !empty($employee->basic_salary) ? ($employee->basic_salary+$total_allowance + $total_commission + $total_other_payment + $total_over_time) : '-';
                    //  priceFormat($employee->basic_salary+$total_allowance + $total_commission + $total_other_payment + $total_over_time);
                    $total_basic_salary = $employee->basic_salary+$total_allowance + $total_commission + $total_other_payment + $total_over_time;
                    // $tmp[] = !empty($employee->net_payble) ? \Auth::user()->priceFormat($employee->net_payble) : '-';
                    $tmp[] = $total_saturation_deduction;
                    $tmp[] = $total_loan;
                    $tmp[] = $total_provident_payment;
                    $tmp[] = $total_taxDeduction;
                    $tmp[] = $total_eobi_payment;
                    $tmp[] = !empty($employee->basic_salary) ? ($total_basic_salary-$total_saturation_deduction-$total_loan-$total_provident_payment- $total_taxDeduction-$total_eobi_payment) : '-';
                    if($employee->status == 1)
                    {
                        $tmp[] = 'Paid';
                    }
                    else
                    {
                        $tmp[] = 'UnPaid';
                    }
                    $tmp[]  = !empty($employee->pay_slip_id) ? $employee->pay_slip_id : 0;
                    $data[] = $tmp;
                }

            }

            return $data;
        }
    }

    public function paysalary($id, $date)
    {

      
        $employeePayslip = PaySlip::where('employee_id', '=', $id)->where('created_by', \Auth::user()->creatorId())->where('salary_month', '=', $date)->first();

        if(!empty($employeePayslip))
        {
            $dateYmd = date('d');
            $getCurrentDate  = $date.'-'.$dateYmd;
            $employeePayslip->status = 1;
            $employeePayslip->save();

            $providentfoundAmount =  json_decode(Employee::Provident($employeePayslip->employee_id));
            $employeeTax =  json_decode(Employee::TAX($employeePayslip->employee_id));
            // $EmployeeEOBI =  json_decode(Employee::EOBI($employeePayslip->employee_id));
           $getCurrentDate  = explode('-',$date);
            $EmployeeEOBI =  EOBI::where('employee_id', $employeePayslip->employee_id)->whereMonth('eobi_date',$getCurrentDate[1])->get();          
            foreach($EmployeeEOBI as $empEobi)
            {
                $dateYmd = date('d');
                $date = $employeePayslip->salary_month.'-'.$dateYmd;
                $employeeName =  Employee::where('id', $empEobi->employee_id)->first();
                $employeeEobi   = new EmployeeeOBI();
                $employeeEobi->employee_id = $empEobi->employee_id;
                $employeeEobi->name = $employeeName->name;
                $employeeEobi->employee_amount        = $empEobi->employee_amount;
                $employeeEobi->employer_amount        = $empEobi->employer_amount;
                $employeeEobi->date      =  $date;
                $employeeEobi->created_by  = $empEobi->created_by;
                $employeeEobi->save();

            }

            foreach($providentfoundAmount as $provident)
            {
                $dateYmd = date('d');
                $date = $employeePayslip->salary_month.'-'.$dateYmd;

                $employeeName =  Employee::where('id', $provident->employee_id)->first();
                $payslipEmployeep   = new ProvidentFound();
                $payslipEmployeep->employee_id = $provident->employee_id;
                $payslipEmployeep->employee_name = $employeeName->name;
                $payslipEmployeep->employee_amount        = $provident->employee_amount;
                $payslipEmployeep->employee_date      = $date;
                $payslipEmployeep->employer_amout        = $provident->employer_amout;
                $payslipEmployeep->employer_date        = $provident->employer_date;
                $payslipEmployeep->created_by  = $provident->created_by;
                $payslipEmployeep->save();
            
            }
            foreach($employeeTax as $empTax)
            {
                $dateYmd = date('d');
                $date = $employeePayslip->salary_month.'-'.$dateYmd;
              
                $employeeName =  Employee::where('id', $empTax->employee_id)->first();
                $employeetax   = new EmployeeTax();
                $employeetax->employee_id = $empTax->employee_id;
                $employeetax->name = $employeeName->name;
                $employeetax->tax_amount        = $empTax->tax_amount;
                $employeetax->date      = $date;
                $employeetax->created_by  = $empTax->created_by;
                $employeetax->save();

            }

            return redirect()->route('payslip.index')->with('success', __('Payslip Payment successfully.'));
        }
        else
        {
            return redirect()->route('payslip.index')->with('error', __('Payslip Payment failed.'));
        }

    }

    public function bulk_pay_create($date)
    {
        $Employees       = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->get();
        $unpaidEmployees = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->where('status', '=', 0)->get();

        return view('payslip.bulkcreate', compact('Employees', 'unpaidEmployees', 'date'));
    }

    public function bulkpayment(Request $request, $date)
    {
        $unpaidEmployees = PaySlip::where('salary_month', $date)->where('created_by', \Auth::user()->creatorId())->where('status', '=', 0)->get();
        foreach($unpaidEmployees as $employee)
        {
            $providentfoundAmount =  json_decode(Employee::Provident($employee->employee_id));
            $employeeTax =  json_decode(Employee::TAX($employee->employee_id));
            $EmployeeEOBI =  json_decode(Employee::EOBI($employee->employee_id));
            foreach($EmployeeEOBI as $empEobi)
            {
                $dateYmd = date('d');
                $date = $unpaidEmployees->salary_month.'-'.$dateYmd;
                $employeeName =  Employee::where('id', $empEobi->employee_id)->first();
                $employeeEobi   = new EmployeeeOBI();
                $employeeEobi->employee_id = $empEobi->employee_id;
                $employeeEobi->name = $employeeName->name;
                $employeeEobi->employee_amount        = $empEobi->employee_amount;
                $employeeEobi->employer_amount        = $empEobi->employer_amount;
                $employeeEobi->date      = $date;
                $employeeEobi->created_by  = $empEobi->created_by;
                $employeeEobi->save();

            }

            foreach($providentfoundAmount as $provident)
            {
                $dateYmd = date('d');
                $date = $unpaidEmployees->salary_month.'-'.$dateYmd;
                $employeeName =  Employee::where('id', $provident->employee_id)->first();
                $payslipEmployeep   = new ProvidentFound();
                $payslipEmployeep->employee_id = $provident->employee_id;
                $payslipEmployeep->employee_name = $employeeName->name;
                $payslipEmployeep->employee_amount        = $provident->employee_amount;
                $payslipEmployeep->employee_date      =$date;
                $payslipEmployeep->employer_amout        = $provident->employer_amout;
                $payslipEmployeep->employer_date        = $provident->employer_date;
                $payslipEmployeep->created_by  = $provident->created_by;
                $payslipEmployeep->save();

            }
            foreach($employeeTax as $empTax)
            {
                $dateYmd = date('d');
                $date = $unpaidEmployees->salary_month.'-'.$dateYmd;
                $employeeName =  Employee::where('id', $empTax->employee_id)->first();
                $employeetax   = new EmployeeTax();
                $employeetax->employee_id = $empTax->employee_id;
                $employeetax->name = $employeeName->name;
                $employeetax->tax_amount        = $empTax->tax_amount;
                $employeetax->date      =  $date ;
                $employeetax->created_by  = $empTax->created_by;
                $employeetax->save();

            }

            $employee->status = 1;
            $employee->save();
        }

        return redirect()->route('payslip.index')->with('success', __('Payslip Bulk Payment successfully.'));
    }

    public function employeepayslip()
    {
        $employees = Employee::where(
            [
                'user_id' => \Auth::user()->id,
            ]
        )->first();

        $payslip = PaySlip::where('employee_id', '=', $employees->id)->get();

        return view('payslip.employeepayslip', compact('payslip'));

    }

    public function pdf($id, $month)
    {

       
        $payslip  = PaySlip::where('employee_id', $id)->where('salary_month', $month)->where('created_by', \Auth::user()->creatorId())->first();

        $employee = Employee::find($payslip->employee_id);

        $payslipDetail = Utility::employeePayslipDetail($id,$month);
        
        // dd($payslipDetail);
        return view('payslip.pdf', compact('payslip', 'employee', 'payslipDetail'));
    }
    public function multiplePdfGenerate(Request $request)
    {
//        URL::full();
        $url = $_SERVER['HTTP_REFERER'];
        parse_str( parse_url( $url, PHP_URL_QUERY), $array );
        $startDate = $array['start_month'];
        $endDate = $array['end_month'];
//        DB::enableQueryLog();

        //dd($array['employee']);
        $payslip = PaySlip::where('employee_id', $array['employee'])
            ->where('salary_month', '>=', $startDate)
            ->where('salary_month', '<=', $endDate)
            ->where('created_by', \Auth::user()->creatorId())
            ->with(['employeeUser' => function ($query) {
                $query->select('id', 'name', 'fname', 'lname', 'cnic');
            }])->groupBy('salary_month')->orderBy('salary_month', "desc")->get()->toArray();
        //dd($payslip);
        $employee = [];
       foreach($payslip as $data){
           $employee = Employee::find($data['employee_id']);
       }
        $payslipDetail = Utility::employeePayslipDetailMultiple($array['employee']);
       //dd(collect($payslipDetail)->toJson());


        return view('payslip.multi-pdf', compact('payslip', 'employee', 'payslipDetail'));
    }


    public function send($id, $month)
    {
        $payslip  = PaySlip::where('employee_id', $id)->where('salary_month', $month)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);

        $payslip->name  = $employee->name;
        $payslip->email = $employee->email;

        $payslipId    = Crypt::encrypt($payslip->id);
        $payslip->url = route('payslip.payslipPdf', $payslipId);

        $setings = Utility::settings();
        if($setings['payroll_create'] == 1)
        {
            try
            {
                Mail::to($payslip->email)->send(new PayslipSend($payslip));
            }
            catch(\Exception $e)
            {
                $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            }

            return redirect()->back()->with('success', __('Payslip successfully sent.') . (isset($smtp_error) ? $smtp_error : ''));
        }

        return redirect()->back()->with('success', __('Payslip successfully sent.'));

    }

    public function payslipPdf($id)
    {
        $payslipId = Crypt::decrypt($id);

        $payslip  = PaySlip::where('id', $payslipId)->where('created_by', \Auth::user()->creatorId())->first();
        $employee = Employee::find($payslip->employee_id);

        $payslipDetail = Utility::employeePayslipDetail($payslip->employee_id);

        return view('payslip.payslipPdf', compact('payslip', 'employee', 'payslipDetail'));
    }

    public function editEmployee($paySlip)
    {
        $payslip = PaySlip::find($paySlip);

        return view('payslip.salaryEdit', compact('payslip'));
    }

    public function updateEmployee(Request $request, $id)
    {


        if(isset($request->allowance) && !empty($request->allowance))
        {
            $allowances   = $request->allowance;
            $allowanceIds = $request->allowance_id;
            foreach($allowances as $k => $allownace)
            {
                $allowanceData         = Allowance::find($allowanceIds[$k]);
                $allowanceData->amount = $allownace;
                $allowanceData->save();
            }
        }


        if(isset($request->commission) && !empty($request->commission))
        {
            $commissions   = $request->commission;
            $commissionIds = $request->commission_id;
            foreach($commissions as $k => $commission)
            {
                $commissionData         = Commission::find($commissionIds[$k]);
                $commissionData->amount = $commission;
                $commissionData->save();
            }
        }

        if(isset($request->loan) && !empty($request->loan))
        {
            $loans   = $request->loan;
            $loanIds = $request->loan_id;
            foreach($loans as $k => $loan)
            {
                $loanData         = Loan::find($loanIds[$k]);
                $loanData->amount = $loan;
                $loanData->save();
            }
        }


        if(isset($request->saturation_deductions) && !empty($request->saturation_deductions))
        {
            $saturation_deductionss   = $request->saturation_deductions;
            $saturation_deductionsIds = $request->saturation_deductions_id;
            foreach($saturation_deductionss as $k => $saturation_deductions)
            {

                $saturation_deductionsData         = SaturationDeduction::find($saturation_deductionsIds[$k]);
                $saturation_deductionsData->amount = $saturation_deductions;
                $saturation_deductionsData->save();
            }
        }


        if(isset($request->other_payment) && !empty($request->other_payment))
        {
            $other_payments   = $request->other_payment;
            $other_paymentIds = $request->other_payment_id;
            foreach($other_payments as $k => $other_payment)
            {
                $other_paymentData         = OtherPayment::find($other_paymentIds[$k]);
                $other_paymentData->amount = $other_payment;
                $other_paymentData->save();
            }
        }


        if(isset($request->rate) && !empty($request->rate))
        {
            $rates   = $request->rate;
            $rateIds = $request->rate_id;
            $hourses = $request->hours;

            foreach($rates as $k => $rate)
            {
                $overtime        = Overtime::find($rateIds[$k]);
                $overtime->rate  = $rate;
                $overtime->hours = $hourses[$k];
                $overtime->save();
            }
        }


        $payslipEmployee                       = PaySlip::find($request->payslip_id);
        $payslipEmployee->allowance            = Employee::allowance($payslipEmployee->employee_id);
        $payslipEmployee->commission           = Employee::commission($payslipEmployee->employee_id);
        $payslipEmployee->loan                 = Employee::loan($payslipEmployee->employee_id);
        $payslipEmployee->saturation_deduction = Employee::saturation_deduction($payslipEmployee->employee_id);
        $payslipEmployee->other_payment        = Employee::other_payment($payslipEmployee->employee_id);
        $payslipEmployee->overtime             = Employee::overtime($payslipEmployee->employee_id);
        $payslipEmployee->net_payble           = Employee::find($payslipEmployee->employee_id)->get_net_salary();
        $payslipEmployee->save();

        return redirect()->route('payslip.index')->with('success', __('Employee payroll successfully updated.'));
    }
}
