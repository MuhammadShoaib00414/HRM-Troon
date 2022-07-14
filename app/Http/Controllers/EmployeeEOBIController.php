<?php

namespace App\Http\Controllers;

use App\Models\EmployeeEOBI;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use DB;
class EmployeeEOBIController extends Controller
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
                $employeeEobis  = EmployeeEOBI::where('created_by', \Auth::user()->creatorId())->
                whereMonth('date',$currentDate)->get();
                $employeeEobi        = [];
                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                foreach($employeeEobis as $emplEobi)
                {

                    $emplEobi['id']    = $emplEobi['id'];
                    $emplEobi['employee_id'] = $emplEobi['employee_id'];
                    $emplEobi['name']    = $emplEobi['name'];
                    $emplEobi['date']    = $emplEobi->date;
                    $grandTotal[] = $emplEobi['employee_amount'];
                    $grandTotalEmployee[] = $emplEobi['employer_amount'];
                    $emplEobi['grand_total_employee'] = array_sum($grandTotal);
                    $emplEobi['grand_total_employer'] = array_sum($grandTotalEmployee);
                    $i++;
                    $empEobi['grand_total_employee'] = array_sum($grandTotal);
                    $empEobi['grand_total_employer'] = array_sum($grandTotalEmployee);
                    $employeeEobi[] = $emplEobi;
                }
                $grandTotal =array_sum($grandTotal);
                $grandTotalEmployee = array_sum($grandTotalEmployee);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = EmployeeEOBI::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                    // dd($employeeEobi);
                return view('employee-eobi.index', compact('employeeEobi', 'filterYear','grandTotal','grandTotalEmployee'));
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
                $employeeEobis  = EmployeeEOBI::where('created_by', \Auth::user()->creatorId())->
                whereYear('date',$currentyear)->get();
                $employeeEobi        = [];
                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                foreach($employeeEobis as $emplEobi)
                {

                    $emplEobi['id']    = $emplEobi['id'];
                    $emplEobi['employee_id'] = $emplEobi['employee_id'];
                    $emplEobi['name']    = $emplEobi['name'];
                    $emplEobi['date']    = $emplEobi->date;
                    $grandTotal[] = $emplEobi['employee_amount'];
                    $grandTotalEmployee[] = $emplEobi['employer_amount'];

                    $emplEobi['grand_total_employee'] = array_sum($grandTotal);
                    $emplEobi['grand_total_employer'] = array_sum($grandTotalEmployee);
                    $i++;

                    $empEobi['grand_total_employee'] = array_sum($grandTotal);

                    $empEobi['grand_total_employer'] = array_sum($grandTotalEmployee);

                    $employeeEobi[] = $emplEobi;
                }

                $grandTotal = array_sum($grandTotal);
                $grandTotalEmployee = array_sum($grandTotalEmployee);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = EmployeeEOBI::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('employee-eobi.index', compact('employeeEobi', 'filterYear','grandTotal','grandTotalEmployee'));

            }
            $employeeEobis  = EmployeeEOBI::where('created_by', \Auth::user()->creatorId())->
            whereYear('date',$currentyear)->get();

            $employeeEobi        = [];
            $grandTotalEmployee = array();
            $i = 0;
            $grandTotal = array();
            foreach($employeeEobis as $emplEobi)
            {

                $emplEobi['id']    = $emplEobi['id'];
                $emplEobi['employee_id'] = $emplEobi['employee_id'];
                $emplEobi['name']    = $emplEobi['name'];
                $emplEobi['date']    = $emplEobi->date;
                $grandTotal[] = $emplEobi['employee_amount'];
                $grandTotalEmployee[] = $emplEobi['employer_amount'];

                $emplEobi['grand_total_employee'] = array_sum($grandTotal);
                $emplEobi['grand_total_employer'] = array_sum($grandTotalEmployee);
                $i++;

                $empEobi['grand_total_employee'] = array_sum($grandTotal);
                $empEobi['grand_total_employer'] = array_sum($grandTotalEmployee);

                $employeeEobi[] = $emplEobi;
            }

            $grandTotal =array_sum($grandTotal);
            $grandTotalEmployee = array_sum($grandTotalEmployee);
            $starting_year = date('Y', strtotime('-5 year'));
            $ending_year   = date('Y', strtotime('+5 year'));
            $filterYear['starting_year'] = $starting_year;
            $filterYear['ending_year']   = $ending_year;
            $filterYear = EmployeeEOBI::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();
            return view('employee-eobi.index', compact('employeeEobi', 'filterYear','grandTotal','grandTotalEmployee'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function EobiStatus(Request $request)
    {
        $currentyear = Carbon::now()->year;
        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {

                $current = $request->month."-1";
                $currentDate = date('m', strtotime($current));

                $employee_eobi = Employee::select(
                    DB::raw("employees.id"),
                    DB::raw("employees.name"),
                    DB::raw("employee_e_o_b_i_s.employee_amount"),
                    DB::raw("employee_e_o_b_i_s.employer_amount"),
                    DB::raw("employee_e_o_b_i_s.date"),
                    DB::raw("employee_e_o_b_i_s.id as opd_id"),
                    DB::raw("(SUM(employee_amount)) as total_employee"),
                    DB::raw("(SUM(employer_amount)) as total_employer")
                )
                    ->leftJoin('employee_e_o_b_i_s', 'employee_e_o_b_i_s.employee_id', '=', 'employees.id')
                    ->orderBy('employees.name','ASC')
                    ->groupBy('employees.name')
                    ->whereMonth('employee_e_o_b_i_s.date',$currentDate)
                    ->get()->toArray();

                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                $employee_eobis = [];
                foreach($employee_eobi as $employee)
                {
                    $employeeE['id'] = $employee['id'];
                    $employeeE['name'] = $employee['name'];
                    $employeeE['employee_amount'] = $employee['employee_amount'];
                    $employeeE['employer_amount'] = $employee['employer_amount'];
                    $employeeE['date'] = $employee['date'];
                    $employeeE['opd_id'] = $employee['opd_id'];
                    $employeeE['total_employee'] = $employee['total_employee'];
                    $employeeE['total_employer'] = $employee['total_employer'];

                    $grandTotal[] = $employee['total_employee'];
                    $grandTotalEmployee[] = $employee['employee_amount'];
                    $grandTotalEmployer[] = $employee['employer_amount'];
                    $employeeE['grand_total_pf'] = array_sum($grandTotal);
                    $employeeE['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $employeeE['grand_total_employer'] = array_sum($grandTotalEmployer);
                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $empEobi['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $empEobi['grand_total_employer'] = array_sum($grandTotalEmployer);
                    $employee_eobis[] = $employee;
                }
                $grandTotal = array_sum($grandTotal);
                $grandTotalEmployee = array_sum($grandTotalEmployee);
                $grandTotalEmployer = array_sum($grandTotalEmployer);


                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = EmployeeEOBI::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('employee-eobi.employee-eobi_status', compact('employee_eobis', 'filterYear','grandTotal','grandTotalEmployee','grandTotalEmployer'));
            }
            elseif(!isset($request->type))
            {
                $monthYear = date('Y-m');
                $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                $filterYear['type']          = __('Monthly');
            }
            if($request->type == 'yearly' && !empty($request->year))
            {

                $employee_eobi = Employee::select(
                    DB::raw("employees.id"),
                    DB::raw("employees.name"),
                    DB::raw("employee_e_o_b_i_s.employee_amount"),
                    DB::raw("employee_e_o_b_i_s.employer_amount"),
                    DB::raw("employee_e_o_b_i_s.date"),
                    DB::raw("employee_e_o_b_i_s.id as opd_id"),
                    DB::raw("(SUM(employee_amount)) as total_employee"),
                    DB::raw("(SUM(employer_amount)) as total_employer")
                )
                    ->leftJoin('employee_e_o_b_i_s', 'employee_e_o_b_i_s.employee_id', '=', 'employees.id')
                    ->orderBy('employees.name','ASC')
                    ->groupBy('employees.name')
                    ->whereYear('employee_e_o_b_i_s.date',$request->year)
                    ->get()->toArray();
                $employee_eobis = [];
                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                foreach($employee_eobi as $employee)
                {
                    $employeeE['id'] = $employee['id'];
                    $employeeE['name'] = $employee['name'];
                    $employeeE['employee_amount'] = $employee['employee_amount'];
                    $employeeE['employer_amount'] = $employee['employer_amount'];
                    $employeeE['date'] = $employee['date'];
                    $employeeE['opd_id'] = $employee['opd_id'];
                    $employeeE['total_employee'] = $employee['total_employee'];
                    $employeeE['total_employer'] = $employee['total_employer'];

                    $grandTotal[] = $employee['total_employee'];
                    $grandTotalEmployee[] = $employee['employee_amount'];
                    $grandTotalEmployer[] = $employee['employer_amount'];
                    $employeeE['grand_total_pf'] = array_sum($grandTotal);
                    $employeeE['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $employeeE['grand_total_employer'] = array_sum($grandTotalEmployer);
                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $empEobi['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $empEobi['grand_total_employer'] = array_sum($grandTotalEmployer);
                    $employee_eobis[] = $employee;
                }
                    

                    if(!empty($grandTotalEmployer)){
                        $grandTotal = array_sum($grandTotal);
                        $grandTotalEmployee = array_sum($grandTotalEmployee);
                        $grandTotalEmployer = array_sum($grandTotalEmployer);
                    }else{
                        $grandTotalEmployer = 0;
                        $grandTotal = 0;
                        $grandTotalEmployee = 0;
                    }

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = EmployeeEOBI::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('employee-eobi.employee-eobi_status', compact('employee_eobis', 'filterYear','grandTotal','grandTotalEmployee','grandTotalEmployer'));
            }
             $employee_eobi = Employee::select(
                DB::raw("employees.id"),
                DB::raw("employees.name"),
                 DB::raw("employee_e_o_b_i_s.employee_amount"),
                 DB::raw("employee_e_o_b_i_s.employer_amount"),
                DB::raw("employee_e_o_b_i_s.date"),
                DB::raw("employee_e_o_b_i_s.id as opd_id"),
                DB::raw("(SUM(employee_amount)) as total_employee"),
                DB::raw("(SUM(employer_amount)) as total_employer")
            )
                ->leftJoin('employee_e_o_b_i_s', 'employee_e_o_b_i_s.employee_id', '=', 'employees.id')
                ->orderBy('employees.name','ASC')
                ->groupBy('employees.name')
                ->whereYear('employee_e_o_b_i_s.date',$currentyear)
                ->get()->toArray();

            $employee_eobis  = [];
            $i = 0;
            $grandTotal = array();
            $grandTotalEmployee = array();
            foreach($employee_eobi as $employee)
            {
                $employeeE['id'] = $employee['id'];
                $employeeE['name'] = $employee['name'];
                $employeeE['employee_amount'] = $employee['employee_amount'];
                $employeeE['employer_amount'] = $employee['employer_amount'];
                $employeeE['date'] = $employee['date'];
                $employeeE['opd_id'] = $employee['opd_id'];
                $employeeE['total_employee'] = $employee['total_employee'];
                $employeeE['total_employer'] = $employee['total_employer'];

                $grandTotal[] = $employee['total_employee'];
                $grandTotalEmployee[] = $employee['employee_amount'];
                $grandTotalEmployer[] = $employee['employer_amount'];
                $employeeE['grand_total_pf'] = array_sum($grandTotal);
                $employeeE['grand_total_employee'] = array_sum($grandTotalEmployee);
                $employeeE['grand_total_employer'] = array_sum($grandTotalEmployer);
                $i++;
                $empEobi['grand_total_pf'] = array_sum($grandTotal);
                $empEobi['grand_total_employee'] = array_sum($grandTotalEmployee);
                $empEobi['grand_total_employer'] = array_sum($grandTotalEmployer);
                $employee_eobis[] = $employee;
            }
               
                if(!empty($grandTotalEmployer)){
                    $grandTotalEmployer = array_sum($grandTotalEmployer);
                    $grandTotal = array_sum($grandTotal);
                    $grandTotalEmployee = array_sum($grandTotalEmployee);
                }else{
                    $grandTotalEmployer = 0;
                    $grandTotal = 0;
                    $grandTotalEmployee = 0;
                }
//            dd($grandTotal);
             $starting_year = date('Y', strtotime('-5 year'));
             $ending_year   = date('Y', strtotime('+5 year'));
             $filterYear['starting_year'] = $starting_year;
             $filterYear['ending_year']   = $ending_year;
            $filterYear = EmployeeEOBI::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();
            return view('employee-eobi.employee-eobi_status', compact('employee_eobis', 'filterYear','grandTotal','grandTotalEmployee','grandTotalEmployer'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function EobiStatusDetails(Request $request)
    {

        $currentyear = Carbon::now()->year;

        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {

                $current = $request->month."-1";
                $currentDate = date('m', strtotime($current));
                $eobi_details = EmployeeEOBI::select(
                    DB::raw("employee_id"),
                    DB::raw("id"),
                    DB::raw("name"),
                    DB::raw("employee_amount"),
                    DB::raw("employer_amount"),
                    DB::raw("date"),
                    DB::raw("MONTHNAME(employee_e_o_b_i_s.date) as month_name"),
            )
                    ->whereYear('date', date('Y'))
                    ->orderBy('date')
                    ->whereMonth('date',$currentDate)
                    ->where('employee_id',request('id'))
                    ->get()
                    ->toArray();

                $eobi_detail = [];
                $i = 0;
                $grandTotal = array();
                foreach($eobi_details as $eobi)
                {

                    $empEobi['id'] = $eobi['id'];
                    $empEobi['name'] = $eobi['name'];
                    $empEobi['month_name'] = $eobi['month_name'];
                    $empEobi['date'] = $eobi['date'];
                    $empEobi['employee_amount'] = $eobi['employee_amount'];
                    $empEobi['total_pf_amount'] = $eobi['employee_amount'];
                    $grandTotal[] = $eobi['employee_amount'];
                    $grandTotalemployer[] = $eobi['employer_amount'];
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $empEobi['grand_total_employer'] = array_sum($grandTotalemployer);

                    $eobi_detail[] = $eobi;

                }
                $grandTotal = array_sum($grandTotal);
                $grandTotalemployer = array_sum($grandTotalemployer);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = EmployeeEOBI::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('employee-eobi.eobi_status_details', compact('eobi_details', 'filterYear','grandTotal','grandTotalemployer'));

            }
            elseif(!isset($request->type))
            {
                $monthYear = date('Y-m');
                $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                $filterYear['type']          = __('Monthly');
            }

            if($request->type == 'yearly' && !empty($request->year))
            {
                $filterYear['dateYearRange'] = $request->year;
                $eobi_details = EmployeeEOBI::select(
                    DB::raw("employee_id"),
                    DB::raw("id"),
                    DB::raw("name"),
                    DB::raw("employee_amount"),
                    DB::raw("employer_amount"),
                    DB::raw("date"),
                    DB::raw("MONTHNAME(employee_e_o_b_i_s.date) as month_name")
            )
                    ->orderBy('date')
                    ->whereYear('date',$request->year)
                    ->get()
                    ->toArray();

                $eobi_detail = [];
                $i = 0;
                $grandTotal = array();
                foreach($eobi_details as $eobi)
                {

                    $empEobi['id'] = $eobi['id'];
                    $empEobi['name'] = $eobi['name'];
                    $empEobi['month_name'] = $eobi['month_name'];
                    $empEobi['date'] = $eobi['date'];
                    $empEobi['employee_amount'] = $eobi['employee_amount'];
                    $empEobi['total_pf_amount'] = $eobi['employee_amount'];
                    $grandTotal[] = $eobi['employee_amount'];
                    $grandTotalemployer[] = $eobi['employer_amount'];
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);

                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $empEobi['grand_total_employer'] = array_sum($grandTotalemployer);
                    $eobi_detail[] = $eobi;

                }
                $grandTotal = array_sum($grandTotal);
                $grandTotalemployer = array_sum($grandTotalemployer);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = EmployeeEOBI::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('employee-eobi.eobi_status_details', compact('eobi_details', 'filterYear','grandTotal','grandTotalemployer'));

            }

            $eobi_details = EmployeeEOBI::select(
                DB::raw("employee_id"),
                DB::raw("id"),
                DB::raw("name"),
                DB::raw("employee_amount"),
                DB::raw("employer_amount"),
                DB::raw("date"),
                DB::raw("MONTHNAME(employee_e_o_b_i_s.date) as month_name"),
            )
                ->whereYear('date', date('Y'))
                ->orderBy('date')
                ->whereYear('date',$currentyear)
                ->where('employee_id',request('id'))
                ->get()
                ->toArray();

            $eobi_detail = [];
            $i = 0;
            $grandTotal = array();
            foreach($eobi_details as $eobi)
            {

                $empEobi['id'] = $eobi['id'];
                $empEobi['name'] = $eobi['name'];
                $empEobi['month_name'] = $eobi['month_name'];
                $empEobi['date'] = $eobi['date'];
                $empEobi['employee_amount'] = $eobi['employee_amount'];
                $empEobi['total_pf_amount'] = $eobi['employee_amount'];

                $grandTotal[] = $eobi['employee_amount'];
                $grandTotalemployer[] = $eobi['employer_amount'];

                $empEobi['grand_total_pf'] = array_sum($grandTotal);

                $empEobi['grand_total_employer'] = array_sum($grandTotalemployer);

                $i++;
                $empEobi['grand_total_pf'] = array_sum($grandTotal);
                $empEobi['grand_total_employer'] = array_sum($grandTotalemployer);

                $eobi_detail[] = $eobi;

            }
            $grandTotal = array_sum($grandTotal);
            $grandTotalemployer = array_sum($grandTotalemployer);
            $starting_year = date('Y', strtotime('-5 year'));
            $ending_year   = date('Y', strtotime('+5 year'));
            $filterYear['starting_year'] = $starting_year;
            $filterYear['ending_year']   = $ending_year;
            $filterYear = EmployeeEOBI::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();
            return view('employee-eobi.eobi_status_details', compact('eobi_details', 'filterYear','grandTotal','grandTotalemployer'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmployeeEOBI  $employeeEOBI
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeEOBI $employeeEOBI)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmployeeEOBI  $employeeEOBI
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeEOBI $employeeEOBI)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeEOBI  $employeeEOBI
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeEOBI $employeeEOBI)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmployeeEOBI  $employeeEOBI
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeEOBI $employeeEOBI)
    {
        //
    }
}
