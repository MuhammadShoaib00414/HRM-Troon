<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\ProvidentFound;
use App\Models\ProvidentRequest;
use DB;
use Carbon\Carbon;
use Session;
class ProvidentFundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $currentyear = Carbon::now()->year;
        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {
                $currentDate = $request->month."-1";

                $currentDate = date('m', strtotime($currentDate));

                $employees  = ProvidentRequest::where('created_by', \Auth::user()->creatorId())
                    ->whereMonth('date',$currentDate);
                $employees = $employees->get();

                $i = 0;
                $grandTotal = array();
                $providetStatus        = [];
                foreach($employees as $employee)
                {
                    $employeeLeave['id']          = $employee->id;
                    $employeeLeave['employee_id'] = $employee->employee_id;
                    $employeeLeave['name']    = $employee->name;
                    $employeeLeave['amount']    = $employee->amount;
                    $employeeLeave['date']    = $employee->date;

                    $grandTotal[] = $employee['amount'];

                    $employeeE['grand_total_pf'] = array_sum($grandTotal);

                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $providetStatus[] = $employeeLeave;
                }
                $grandTotal = array_sum($grandTotal);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));

                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;


                return view('providentfund.index', compact('providetStatus', 'filterYear','grandTotal'));

            }
            elseif(!isset($request->type))
            {
                $monthYear = date('Y-m');
                $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                $filterYear['type']          = __('Monthly');
            }
            if($request->type == 'yearly' && !empty($request->year))
            {


                $currentyear = $request->year;

                $employees  = ProvidentRequest::where('created_by', \Auth::user()->creatorId())
                    ->whereYear('date', $currentyear);
                $employees = $employees->get();

                $i = 0;
                $grandTotal = array();
                $providetStatus        = [];
                foreach($employees as $employee)
                {
                    $employeeLeave['id']          = $employee->id;
                    $employeeLeave['employee_id'] = $employee->employee_id;
                    $employeeLeave['name']    = $employee->name;
                    $employeeLeave['amount']    = $employee->amount;
                    $employeeLeave['date']    = $employee->date;

                    $grandTotal[] = $employee['amount'];

                    $employeeE['grand_total_pf'] = array_sum($grandTotal);

                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $providetStatus[] = $employeeLeave;
                }
                $grandTotal = array_sum($grandTotal);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));

                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;


                return view('providentfund.index', compact('providetStatus', 'filterYear','grandTotal'));

            }

            $employees  = ProvidentRequest::where('created_by', \Auth::user()->creatorId())->
            whereYear('date',$currentyear);
            $employees = $employees->get();
            $i = 0;
            $grandTotal = array();
            $providetStatus        = [];
            foreach($employees as $employee)
            {
                $employeeLeave['id']          = $employee->id;
                $employeeLeave['employee_id'] = $employee->employee_id;
                $employeeLeave['name']    = $employee->name;
                $employeeLeave['amount']    = $employee->amount;
                $employeeLeave['date']    = $employee->date;

                $grandTotal[] = $employee['amount'];

                $employeeE['grand_total_pf'] = array_sum($grandTotal);

                $i++;
                $empEobi['grand_total_pf'] = array_sum($grandTotal);
                $providetStatus[] = $employeeLeave;
            }
            $grandTotal = array_sum($grandTotal);

            $starting_year = date('Y', strtotime('-5 year'));
            $ending_year   = date('Y', strtotime('+5 year'));

            $filterYear['starting_year'] = $starting_year;
            $filterYear['ending_year']   = $ending_year;


            return view('providentfund.index', compact('providetStatus', 'filterYear','grandTotal'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
    public function providentfunddetails(Request $request)
    {


        if(\Auth::user()->can('manage report'))
        {
            $currentyear = Carbon::now()->year;
            if($request->type == 'monthly' && !empty($request->month))
            {
                $current = $request->month."-1";
                $currentDate = date('m', strtotime($current));
//                dd($currentDate);
                $filterYear['dateYearRange'] = date('M-Y', strtotime($request->month));
                $filterYear['type']          = __('Monthly');
                $employees = ProvidentFound::select(
                    DB::raw("(COUNT(*)) as count"),
                    DB::raw("(SUM(employee_amount)) as total_employee_amount"),
                    DB::raw("MONTHNAME(employee_date) as month_name"),
                    DB::raw("provident_requests.employee_id"),
                    DB::raw("provident_founds.employee_id as fund_id"),
                    DB::raw("MONTHNAME(date) as request_month_name"),
                    DB::raw("provident_founds.employee_date"),
                    DB::raw("provident_founds.id"),
                    DB::raw("employee_name"),
                    DB::raw("employee_amount"),
                    DB::raw("employer_amout"),
                    DB::raw("amount"),
                    DB::raw("date")
                )
                    ->Leftjoin('provident_requests', 'provident_founds.employee_id', '=', 'provident_requests.employee_id')
                    ->whereYear('employee_date', date('Y'))
                    ->groupBy('month_name')
                    ->orderBy('employee_date')
                    ->whereMonth('employee_date', $currentDate)
                    ->where('provident_founds.employee_id',request('id'))
                    ->get()
                    ->toArray();
                $providentFunds        = [];
                $i = 0;
                $grandTotal = array();
                $grandEmployeeAmount = array();
                $grandEmployerAmount = array();
                foreach($employees as $employee)
                {
                    $employeeLeave['id'] = $employee['id'];
                    $employeeLeave['employee_id'] = $employee['employee_id'];
                    $employeeLeave['fund_id'] = $employee['fund_id'];
                    $employeeLeave['employee_name'] = $employee['employee_name'];
                    $employeeLeave['employee_amount'] = $employee['employee_amount'];
                    $employeeLeave['employee_date'] = $employee['employee_date'];
                    $employeeLeave['employer_amout'] = $employee['employer_amout'];
                    $employeeLeave['amount'] = $employee['amount'];
//                    $employeeLeave['total_employee_amount'] = $employee['total_employee_amount'];
                    $employeeLeave['month_name'] = $employee['month_name'];
                    $employeeLeave['date'] = $employee['date'];
                    $employeeLeave['request_month_name'] = $employee['request_month_name'];
                    $employeeLeave['pf_balance'] = $employee['employee_amount'] + $employee['employer_amout'];

                    if (isset($employeeLeave['pf_balance'])) {
                        $employeeLeave['total_pf_balance'] = isset($employeeLeave['total_pf_balance'])
                            ? $employeeLeave['total_pf_balance'] + $employeeLeave['pf_balance']
                            : $employeeLeave['pf_balance'];
                    }
                    if ($employeeLeave['request_month_name'] === $employeeLeave['month_name'] && $employeeLeave['fund_id'] === $employeeLeave['employee_id']){
                        $employeeLeave['total_pf_balance'] -= $employeeLeave['amount'];
                    }
                    $grandTotal[] = $employeeLeave['total_pf_balance'];
                    $grandEmployeeAmount[] = $employeeLeave['employee_amount'];
                    $grandEmployerAmount[] = $employeeLeave['employer_amout'];
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);

                    $i++;


                    $providentFunds[] = $employeeLeave;
                }

                $total_previous_balance = ProvidentFound::select(
                    DB::raw('SUM(provident_founds.employee_amount) as total_balance_employee'),
                    DB::raw('SUM(provident_founds.employer_amout) as total_balance_employer')
                )
                    ->whereMonth('employee_date','=',$currentDate)
                    ->where('employee_id', request('id'))
                    ->get()
                    ->toArray();


                foreach ($total_previous_balance as $total_pf) {
                    $total_previous_balance = $total_pf['total_balance_employee'] + $total_pf['total_balance_employer'];
                }
                $get_year = ProvidentFound::select('employee_id',
                    'employee_date'
                )
                    ->groupBy(DB::raw("YEAR(employee_date)"))
                    ->get()
                    ->toArray();

                $grandTotal = array_sum($grandTotal);
                $grandEmployeeAmount = array_sum($grandEmployeeAmount);
                $grandEmployerAmount = array_sum($grandEmployerAmount);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                return view('providentfund.providentDetails', compact('get_year','total_previous_balance','providentFunds', 'filterYear','grandEmployerAmount','grandTotal','grandEmployeeAmount'));

            }
            elseif(!isset($request->type))
            {

                $currentyear = Carbon::now()->year;
                $employees = ProvidentFound::select(
//                    DB::raw("(COUNT(*)) as count"),
//                    DB::raw("(SUM(employee_amount)) as total_employee_amount"),
                    DB::raw("MONTHNAME(employee_date) as month_name"),
                    DB::raw("provident_requests.employee_id"),
                    DB::raw("MONTHNAME(date) as request_month_name"),
                    DB::raw("provident_founds.employee_date"),
                    DB::raw("provident_founds.id"),
                    DB::raw("provident_founds.employee_id as fund_id"),
                    DB::raw("employee_name"),
                    DB::raw("employee_amount"),
                    DB::raw("employer_amout"),
                    DB::raw("amount"),
                    DB::raw("date")
                )
                    ->Leftjoin('provident_requests', 'provident_founds.employee_id', '=', 'provident_requests.employee_id')
                     ->groupBy('month_name')
                    ->orderBy('employee_date')
//                    ->whereYear('employee_date', $currentyear)
                    ->where('provident_founds.employee_id',request('id'))
                    ->get()
                    ->toArray();


                $providentFunds        = [];
                $i = 0;
                $grandTotal = array();
                $grandEmployeeAmount = array();
                $grandEmployerAmount = array();
                foreach($employees as $employee)
                {
                    $employeeLeave['id'] = $employee['id'];
                    $employeeLeave['employee_id'] = $employee['employee_id'];
                    $employeeLeave['fund_id'] = $employee['fund_id'];
                    $employeeLeave['employee_name'] = $employee['employee_name'];
                    $employeeLeave['employee_amount'] = $employee['employee_amount'];
                    $employeeLeave['employee_date'] = $employee['employee_date'];
                    $employeeLeave['employer_amout'] = $employee['employer_amout'];
                    $employeeLeave['amount'] = $employee['amount'];
//                    $employeeLeave['total_employee_amount'] = $employee['total_employee_amount'];
                    $employeeLeave['month_name'] = $employee['month_name'];
                    $employeeLeave['date'] = $employee['date'];
                    $employeeLeave['request_month_name'] = $employee['request_month_name'];
                    $employeeLeave['pf_balance'] = $employee['employee_amount'] + $employee['employer_amout'];

                    if (isset($employeeLeave['pf_balance'])) {
                        $employeeLeave['total_pf_balance'] = isset($employeeLeave['total_pf_balance'])
                            ? $employeeLeave['total_pf_balance'] + $employeeLeave['pf_balance']
                            : $employeeLeave['pf_balance'];
                    }
                    if ($employeeLeave['request_month_name'] === $employeeLeave['month_name'] && $employeeLeave['fund_id'] === $employeeLeave['employee_id']){
                        $employeeLeave['total_pf_balance'] -= $employeeLeave['amount'];
                    }
                    $grandTotal[] = $employeeLeave['total_pf_balance'];
                    $grandEmployeeAmount[] = $employeeLeave['employee_amount'];
                    $grandEmployerAmount[] = $employeeLeave['employer_amout'];
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $i++;
                    $providentFunds[] = $employeeLeave;
                }
                $total_previous_balance = ProvidentFound::select(
                    DB::raw('SUM(provident_founds.employee_amount) as total_balance_employee'),
                    DB::raw('SUM(provident_founds.employer_amout) as total_balance_employer')
                )
                    ->where('employee_date','<',$currentyear)
                    ->where('employee_id', request('id'))
                    ->get()
                    ->toArray();

                foreach ($total_previous_balance as $total_pf) {
                    $total_previous_balance = $total_pf['total_balance_employee'] + $total_pf['total_balance_employer'];
                }

                $get_year = ProvidentFound::select('employee_id',
                    'employee_date'
                )
                    ->groupBy(DB::raw("YEAR(employee_date)"))
                    ->get()
                    ->toArray();
                $grandTotal = array_sum($grandTotal);
                $grandEmployeeAmount = array_sum($grandEmployeeAmount);
                $grandEmployerAmount = array_sum($grandEmployerAmount);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                return view('providentfund.providentDetails', compact('get_year','total_previous_balance','providentFunds', 'filterYear','grandEmployerAmount','grandTotal','grandEmployeeAmount'));

            }
            if($request->type == 'yearly' && !empty($request->year))
            {
                $currentyear = $request->year;

                $filterYear['dateYearRange'] = $request->year;
                $filterYear['type']          = __('Yearly');
                $employees = ProvidentFound::select(
                    DB::raw("(COUNT(*)) as count"),
                    DB::raw("(SUM(employee_amount)) as total_employee_amount"),
                    DB::raw("MONTHNAME(employee_date) as month_name"),
                    DB::raw("provident_requests.employee_id"),
                    DB::raw("MONTHNAME(date) as request_month_name"),
                    DB::raw("provident_founds.employee_date"),
                    DB::raw("provident_founds.id"),
                    DB::raw("provident_founds.employee_id as fund_id"),
                    DB::raw("employee_name"),
                    DB::raw("employee_amount"),
                    DB::raw("employer_amout"),
                    DB::raw("amount"),
                    DB::raw("date")
                )
                    ->Leftjoin('provident_requests', 'provident_founds.employee_id', '=', 'provident_requests.employee_id')
//                        ->whereYear('employee_date', date('Y'))
                    ->groupBy('month_name')
                    ->orderBy('employee_date','DESC')
                    ->whereYear('employee_date', $currentyear)
                    ->where('provident_founds.employee_id',request('id'))
                    ->get()
                    ->toArray();


                $providentFunds        = [];
                $i = 0;
                $grandTotal = array();
                $grandEmployeeAmount = array();
                $grandEmployerAmount = array();
                foreach($employees as $employee)
                {
                    $employeeLeave['id'] = $employee['id'];
                    $employeeLeave['employee_id'] = $employee['employee_id'];
                    $employeeLeave['fund_id'] = $employee['fund_id'];
                    $employeeLeave['employee_name'] = $employee['employee_name'];
                    $employeeLeave['employee_amount'] = $employee['employee_amount'];
                    $employeeLeave['employee_date'] = $employee['employee_date'];
                    $employeeLeave['employer_amout'] = $employee['employer_amout'];
                    $employeeLeave['amount'] = $employee['amount'];
//                    $employeeLeave['total_employee_amount'] = $employee['total_employee_amount'];
                    $employeeLeave['month_name'] = $employee['month_name'];
                    $employeeLeave['date'] = $employee['date'];
                    $employeeLeave['request_month_name'] = $employee['request_month_name'];
                    $employeeLeave['pf_balance'] = $employee['employee_amount'] + $employee['employer_amout'];

                    if (isset($employeeLeave['pf_balance'])) {
                        $employeeLeave['total_pf_balance'] = isset($employeeLeave['total_pf_balance'])
                            ? $employeeLeave['total_pf_balance'] + $employeeLeave['pf_balance']
                            : $employeeLeave['pf_balance'];
                    }

                    if ($employeeLeave['request_month_name'] === $employeeLeave['month_name'] && $employeeLeave['fund_id'] === $employeeLeave['employee_id']){
                        $employeeLeave['total_pf_balance'] -= $employeeLeave['amount'];
                    }
                   
                    $grandTotal[] = $employeeLeave['total_pf_balance'];
                    $grandEmployeeAmount[] = $employeeLeave['employee_amount'];
                    $grandEmployerAmount[] = $employeeLeave['employer_amout'];
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $i++;
                    $providentFunds[] = $employeeLeave;
                }

                $total_previous_balance = ProvidentFound::select(
                    DB::raw('SUM(provident_founds.employee_amount) as total_balance_employee'),
                    DB::raw('SUM(provident_founds.employer_amout) as total_balance_employer')
                )

                    ->where('employee_date','<',$currentyear)
                    ->where('employee_id', request('id'))
                    ->get()
                    ->toArray();


                foreach ($total_previous_balance as $total_pf) {
                    $total_previous_balance = $total_pf['total_balance_employee'] + $total_pf['total_balance_employer'];
                }
                $get_year = ProvidentFound::select('employee_id',
                'employee_date'
            )
                ->groupBy(DB::raw("YEAR(employee_date)"))
                ->get()
                ->toArray();

                $grandTotal = array_sum($grandTotal);
                $grandEmployeeAmount = array_sum($grandEmployeeAmount);
                $grandEmployerAmount = array_sum($grandEmployerAmount);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                return view('providentfund.providentDetails', compact('get_year','total_previous_balance','providentFunds', 'filterYear','grandEmployerAmount','grandTotal','grandEmployeeAmount'));

            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function providentFund(Request $request)
    {

        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {

                $current = $request->month."-1";
                $currentDate = date('m', strtotime($current));

                $employees = ProvidentFound::select(
                    DB::raw("provident_founds.employee_id as found_id"),
                    DB::raw("provident_requests.employee_id as request_id"),
                    DB::raw("MONTHNAME(provident_founds.employee_date) as month_name"),
                    DB::raw('SUM(provident_founds.employee_amount) as subscriptionAmount'),
                    DB::raw('SUM(provident_founds.employer_amout) as contributionAmount'),
                    DB::raw("provident_founds.employee_name"),
                    DB::raw("provident_founds.employee_amount"),
                    DB::raw("provident_founds.employer_amout"),
                    DB::raw("provident_founds.employee_date"),
                    DB::raw("provident_requests.amount"),
                    DB::raw("provident_requests.date"),
                    DB::raw("MONTHNAME(date) as request_month_name")
                )
                    ->Leftjoin('provident_requests', 'provident_founds.employee_id', '=', 'provident_requests.employee_id')
                    ->groupBy('provident_founds.employee_id')
                    ->orderBy('provident_requests.date' ,'ASC')
                    ->whereMonth('employee_date', $currentDate)

                    ->get()
                    ->toArray();

                $providentFound        = [];
                $totalrequest = 0;
                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                $grandTotalRequest = array();
                $grandTotalBalance = array();
                $grandTotalEmployer = array();
                foreach($employees as $employee)
                {
                    $employeeFound['found_id']    = $employee['found_id'];
                    $employeeFound['request_id'] = $employee['request_id'];
                    $employeeFound['month_name'] = $employee['month_name'];
                    $employeeFound['employee_name']    = $employee['employee_name'];
                    $employeeFound['employee_amount']    = $employee['employee_amount'];
                    $employeeFound['employer_amout']    = $employee['employer_amout'];
                    $employeeFound['request_amount']    = $employee['amount'];
                    $employeeFound['employee_date']    = date('Y', strtotime($employee['employee_date']));
                    $employeeFound['request_date']    = date('Y', strtotime($employee['date']));
                    $employeeFound['subscriptionAmount']    =$employee['subscriptionAmount'];
                    $employeeFound['contributionAmount']    = $employee['contributionAmount'];
                    $employeeFound['subscription_pf'] =  $employeeFound['subscriptionAmount'] +  $employeeFound['contributionAmount'];

                    $grandTotal[] = $employeeFound['subscriptionAmount'];
                    $grandTotalEmployer[] = $employeeFound['contributionAmount'];
                    $grandTotalRequest[] = $employee['amount'];
                    $grandTotalBalance[] = $employeeFound['subscriptionAmount'] +  $employeeFound['contributionAmount'];;

                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $employeeLeave['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $employeeLeave['grand_total_employer'] = array_sum($grandTotalEmployer);

                    $employeeLeave['grand_total_request'] = array_sum($grandTotalRequest);
                    $employeeLeave['grand_total_balance'] = array_sum($grandTotalBalance);
                    $i++;
                    $providentFound[] = $employeeFound;
                }
                $total_previous_balance = ProvidentFound::select(
                    DB::raw('SUM(provident_founds.employee_amount) as total_balance_employee'),
                    DB::raw('SUM(provident_founds.employer_amout) as total_balance_employer')
                )
                    ->whereMonth('employee_date','=', $currentDate)
                    ->get()
                    ->toArray();

                foreach ($total_previous_balance as $total_pf) {
                    $total_previous_balance = $total_pf['total_balance_employee'] + $total_pf['total_balance_employer'];
                }
                $get_year = ProvidentFound::select('employee_id',
                    'employee_date'
                )
                    ->groupBy(DB::raw("YEAR(employee_date)"))
                    ->get()
                    ->toArray();
                $grandTotalRequest = array_sum($grandTotalRequest);
                $grandTotal =  array_sum($grandTotal);
                $grandTotalEmployee =  array_sum($grandTotalEmployee);
                $grandTotalEmployer =  array_sum($grandTotalEmployer);
                $grandTotalBalance =  array_sum($grandTotalBalance);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;

                $total_previous_balance = $total_previous_balance + $grandTotalBalance ;

                return view('providentfund.provident', compact('get_year','total_previous_balance','grandTotalEmployer','providentFound', 'filterYear','grandTotal','grandTotalEmployee','grandTotalRequest','grandTotalBalance'));

            }
            elseif(!isset($request->type))
            {

                $currentyear = Carbon::now()->year;
                $filterYear['type'] = __('Monthly');
                $filterYear['dateYearRange'] = date('Y-m');

                $employees = ProvidentFound::select(
                    DB::raw("provident_founds.employee_id as found_id"),
                    DB::raw("provident_requests.employee_id as request_id"),
                    DB::raw("MONTHNAME(provident_founds.employee_date) as month_name"),
                    DB::raw('SUM(provident_founds.employee_amount) as subscriptionAmount'),
                    DB::raw('SUM(provident_founds.employer_amout) as contributionAmount'),
                    DB::raw("provident_founds.employee_name"),
                    DB::raw("provident_founds.employee_amount"),
                    DB::raw("provident_founds.employer_amout"),
                    DB::raw("provident_founds.employee_date"),
                    DB::raw("provident_requests.amount"),
                    DB::raw("provident_requests.date"),
                    DB::raw("MONTHNAME(date) as request_month_name")
                )
                    ->Leftjoin('provident_requests', 'provident_founds.employee_id', '=', 'provident_requests.employee_id')
                    ->groupBy('provident_founds.employee_id')

                    ->get()
                    ->toArray();
//           dd($employees);
                $providentFound        = [];
                $totalrequest = 0;
                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                $grandTotalRequest = array();
                $grandTotalBalance = array();
                $grandTotalEmployer = array();
                foreach($employees as $employee)
                {
                    $employeeFound['found_id']    = $employee['found_id'];
                    $employeeFound['request_id'] = $employee['request_id'];
                    $employeeFound['month_name'] = $employee['month_name'];
                    $employeeFound['employee_name']    = $employee['employee_name'];
                    $employeeFound['employee_amount']    = $employee['employee_amount'];
                    $employeeFound['employer_amout']    = $employee['employer_amout'];
                    $employeeFound['request_amount']    = $employee['amount'];
                    $employeeFound['employee_date']    = date('Y', strtotime($employee['employee_date']));
                    $employeeFound['request_date']    = date('Y', strtotime($employee['date']));
                    $employeeFound['subscriptionAmount']    =$employee['subscriptionAmount'];
                    $employeeFound['contributionAmount']    = $employee['contributionAmount'];
                    $employeeFound['subscription_pf'] =  $employeeFound['subscriptionAmount'] +  $employeeFound['contributionAmount'];

                    $grandTotal[] = $employeeFound['subscriptionAmount'];

                    $grandTotalEmployer[] = $employeeFound['contributionAmount'];
                    $grandTotalRequest[] = $employee['amount'];
                    $grandTotalBalance[] = $employeeFound['subscriptionAmount'] +  $employeeFound['contributionAmount'];;

                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $employeeLeave['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $employeeLeave['grand_total_employer'] = array_sum($grandTotalEmployer);

                    $employeeLeave['grand_total_request'] = array_sum($grandTotalRequest);
                    $employeeLeave['grand_total_balance'] = array_sum($grandTotalBalance);
                    $i++;
                    $providentFound[] = $employeeFound;
                }

                $total_previous_balance = ProvidentFound::select(
                    DB::raw('SUM(provident_founds.employee_amount) as total_balance_employee'),
                    DB::raw('SUM(provident_founds.employer_amout) as total_balance_employer')
                )
                    ->where('employee_date','<', $currentyear)
                    ->get()
                    ->toArray();

                foreach ($total_previous_balance as $total_pf) {
                    $total_previous_balance = $total_pf['total_balance_employee'] + $total_pf['total_balance_employer'];
                }

                $grandTotalRequest = array_sum($grandTotalRequest);
                $grandTotal =  array_sum($grandTotal);
                $grandTotalEmployee =  array_sum($grandTotalEmployee);
                $grandTotalEmployer =  array_sum($grandTotalEmployer);
                $grandTotalBalance =  array_sum($grandTotalBalance);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;

                $get_year = ProvidentFound::select('employee_id',
                    'employee_date'
                )
                    ->groupBy(DB::raw("YEAR(employee_date)"))
                    ->get()
                    ->toArray();

                return view('providentfund.provident', compact('get_year','total_previous_balance','grandTotalEmployer','providentFound', 'filterYear','grandTotal','grandTotalEmployee','grandTotalRequest','grandTotalBalance'));
             }
            }
            if($request->type == 'yearly' && !empty($request->year))
            {
                $filterYear['dateYearRange'] = $request->year;
                $filterYear['type']          = __('Yearly');
                $employees = ProvidentFound::select(
                    DB::raw("provident_founds.employee_id as found_id"),
                    DB::raw("provident_requests.employee_id as request_id"),
                    DB::raw("MONTHNAME(provident_founds.employee_date) as month_name"),
                    DB::raw('SUM(provident_founds.employee_amount) as subscriptionAmount'),
                    DB::raw('SUM(provident_founds.employer_amout) as contributionAmount'),
                    DB::raw("provident_founds.employee_name"),
                    DB::raw("provident_founds.employee_amount"),
                    DB::raw("provident_founds.employer_amout"),
                    DB::raw("provident_founds.employee_date"),
                    DB::raw("provident_requests.amount"),
                    DB::raw("provident_requests.date"),
                    DB::raw("MONTHNAME(date) as request_month_name")
                )
                    ->Leftjoin('provident_requests', 'provident_founds.employee_date','>=', 'provident_requests.date')
                    ->groupBy('provident_founds.employee_id')
//                    ->orderBy('employee_date')
//                    ->whereYear('provident_founds.employee_date', $request->year)
                    ->whereYear('employee_date','<=', $request->year)
                    ->get()

                    ->toArray();

                $providentFound        = [];
                $totalrequest = 0;
                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                $grandTotalRequest = array();
                $grandTotalBalance = array();
                $grandTotalEmployer = array();
                foreach($employees as $employee)
                {
                    $employeeFound['found_id']    = $employee['found_id'];
                    $employeeFound['request_id'] = $employee['request_id'];
                    $employeeFound['month_name'] = $employee['month_name'];
                    $employeeFound['employee_name']    = $employee['employee_name'];
                    $employeeFound['employee_amount']    = $employee['employee_amount'];
                    $employeeFound['employer_amout']    = $employee['employer_amout'];
                    $employeeFound['request_amount']    = $employee['amount'];
                    $employeeFound['employee_date']    = date('Y', strtotime($employee['employee_date']));
                    $employeeFound['request_date']    = date('Y', strtotime($employee['date']));
                    $employeeFound['subscriptionAmount']    =$employee['subscriptionAmount'];
                    $employeeFound['contributionAmount']    = $employee['contributionAmount'];
                    $employeeFound['subscription_pf'] =  $employeeFound['subscriptionAmount'] +  $employeeFound['contributionAmount'];

                    $grandTotal[] = $employeeFound['subscriptionAmount'];

                    $grandTotalEmployer[] = $employeeFound['contributionAmount'];
                    $grandTotalRequest[] = $employee['amount'];
                    $grandTotalBalance[] = $employeeFound['subscriptionAmount'] +  $employeeFound['contributionAmount'];;

                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $employeeLeave['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $employeeLeave['grand_total_employer'] = array_sum($grandTotalEmployer);
                    $grandTotalEmployer[] = $employeeFound['contributionAmount'];

                    $employeeLeave['grand_total_request'] = array_sum($grandTotalRequest);
                    $employeeLeave['grand_total_balance'] = array_sum($grandTotalBalance);
                    $i++;
                    $providentFound[] = $employeeFound;
                }

                $total_previous_balance = ProvidentFound::select(
                    DB::raw('SUM(provident_founds.employee_amount) as total_balance_employee'),
                    DB::raw('SUM(provident_founds.employer_amout) as total_balance_employer')
                )
                    ->whereYear('employee_date','<=', $request->year)
                    ->get()
                    ->toArray();

                foreach ($total_previous_balance as $total_pf) {
                    $total_previous_balance = $total_pf['total_balance_employee'] + $total_pf['total_balance_employer'];
               }



                $get_year = ProvidentFound::select('employee_id',
                    'employee_date'
                )
                    ->groupBy(DB::raw("YEAR(employee_date)"))
                    ->get()
                    ->toArray();

                $grandTotalRequest = array_sum($grandTotalRequest);
                $grandTotal =  array_sum($grandTotal);
                $grandTotalEmployee =  array_sum($grandTotalEmployee);

                $grandTotalEmployer =  array_sum($grandTotalEmployer);
                $grandTotalBalance =  array_sum($grandTotalBalance);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;

                $total_previous_balance = $total_previous_balance;
//                dd($total_previous_balance);
                return view('providentfund.provident', compact('get_year','total_previous_balance','grandTotalEmployer','providentFound', 'filterYear','grandTotal','grandTotalEmployee','grandTotalRequest','grandTotalBalance'));
            }

        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $employee = DB::table('employees')->select('employees.name','employees.id')
            ->rightJoin('provident_founds', 'provident_founds.employee_id', '=', 'employees.id')->groupBy('employees.id')->get()->toArray();

        return view('providentfund.create', compact('employee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = \Validator::make(
            $request->all(), [
                'employee_id' => 'required',
                'amount' => 'required',
                'date' => 'required',

            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $employeeName =  Employee::where('id', $request->employee_id)->first();



        $provident = new ProvidentRequest();
        $provident->employee_id    = $request->employee_id;
        $provident->name    = $employeeName['name'];

        $provident->amount     = $request->amount;
        $provident->date = $request->date;

        $provident->note           = $request->note;
        $provident->created_by     = \Auth::user()->creatorId();
        $provident->save();
        return redirect()->back()->with('success', __('Provident Fund Request successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,ProvidentRequest $providentFound)
    {


        if(request('id'))
        {
            DB::table('provident_requests')->where('id', request('id'))->delete();



            return redirect()->route('request-provident.index')->with('success', __('Provident Fund successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }
}
