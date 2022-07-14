<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\OPDPayment;
use App\Models\AllocatedAmount;
use Carbon\Carbon;
use Auth;
use DB;
use File;
class OPDController extends Controller
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

                $current = $request->month."-1";
                $currentDate = date('m', strtotime($current));
                $employees  = OPDPayment::
                where('o_p_d_payments.created_by', \Auth::user()->creatorId())->
                whereMonth('date',$currentDate);
                $employees = $employees->get();
                $opdpaymentss        = [];
                $i = 0;
                $grandTotal = array();
                foreach($employees as $opdPayment)
                {
                    $opdpaymnet['id']          = $opdPayment->id;
                    $opdpaymnet['employee_id'] = $opdPayment->employee_id;
                    $opdpaymnet['name']    = $opdPayment->name;
                    $opdpaymnet['amount']    = $opdPayment->amount;
                    $opdpaymnet['date']    = $opdPayment->date;
                    $opdpaymnet['attachment']    = $opdPayment->attachment;
                    $employeeE['amount'] = $opdPayment['amount'];

                    $grandTotal[] = $opdPayment['amount'];
                    $i++;
                    $empEobi['amount'] = array_sum($grandTotal);
                    $opdpaymentss[] = $opdpaymnet;
                }
                $grandTotal = array_sum($grandTotal);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                $allocated_amount  = AllocatedAmount::query()
                    ->select('id as pro_id','allocated_amounts.*',
                        DB::raw('SUM(allocated_amounts.set_total_opd) as set_total_opd'),
                        DB::raw('SUM(allocated_amounts.set_total_employee_opd) as set_total_employee_opd'))
                    ->where('allocated_amounts.created_by', \Auth::user()->creatorId())
                    ->whereMonth('year',$currentDate)->get()->toArray();

                $set_total_opd = array();
                $set_total_employee_opd = array();
                $allocated_amounts    = [];
                $i = 0;
                foreach($allocated_amount as $allocated)
                {
                    $allocateds['id']  = $allocated['id'];
                    $allocateds['set_total_opd']  = $allocated['set_total_opd'];
                    $allocateds['set_total_employee_opd'] = $allocated['set_total_employee_opd'];
                    $set_total_opd[] = $allocated['set_total_opd'];
                    $set_total_employee_opd[] = $allocated['set_total_employee_opd'];
                    $i++;
                    $allocateds['set_total_opd'] = array_sum($set_total_opd);
                    $allocateds['set_total_employee_opd'] = array_sum($set_total_employee_opd);
                    $allocated_amounts[] = $allocated;
                }
                $set_total_opd = array_sum($set_total_opd);
                return view('opdPayment.index', compact('opdpaymentss', 'filterYear','grandTotal','set_total_opd','set_total_employee_opd'));
            }
            elseif(!isset($request->type))
            {
                $monthYear = date('Y-m');
                $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                $filterYear['type']          = __('Monthly');
            }
            if($request->type == 'yearly' && !empty($request->year))
            {
                $employees  = OPDPayment::
                    where('o_p_d_payments.created_by', \Auth::user()->creatorId())->
                    whereYear('date',$request->year);
                $employees = $employees->get();
                $opdpaymentss        = [];
                $i = 0;
                $grandTotal = array();
                foreach($employees as $opdPayment)
                {
                    $opdpaymnet['id']          = $opdPayment->id;
                    $opdpaymnet['employee_id'] = $opdPayment->employee_id;
                    $opdpaymnet['name']    = $opdPayment->name;
                    $opdpaymnet['amount']    = $opdPayment->amount;
                    $opdpaymnet['totalAmount']    = $opdPayment->totalAmount;
                    $opdpaymnet['date']    = $opdPayment->date;
                    $opdpaymnet['attachment']    = $opdPayment->attachment;
                    $employeeE['amount'] = $opdPayment['amount'];
                    $grandTotal[] = $opdPayment['amount'];
                    $i++;
                    $empEobi['amount'] = array_sum($grandTotal);
                    $opdpaymentss[] = $opdpaymnet;
                }
                $grandTotal = array_sum($grandTotal);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                $allocated_amount  = AllocatedAmount::query()
                    ->select('id as pro_id','allocated_amounts.*',
                        DB::raw('SUM(allocated_amounts.set_total_opd) as set_total_opd'),
                        DB::raw('SUM(allocated_amounts.set_total_employee_opd) as set_total_employee_opd'))
                    ->where('allocated_amounts.created_by', \Auth::user()->creatorId())
                    ->whereYear('year',$request->year)->get()->toArray();

                $set_total_opd = array();
                $set_total_employee_opd = array();
                $allocated_amounts    = [];
                $i = 0;
                foreach($allocated_amount as $allocated)
                {
                    $allocateds['id']  = $allocated['id'];
                    $allocateds['set_total_opd']  = $allocated['set_total_opd'];
                    $allocateds['set_total_employee_opd'] = $allocated['set_total_employee_opd'];
                    $set_total_opd[] = $allocated['set_total_opd'];
                    $set_total_employee_opd[] = $allocated['set_total_employee_opd'];
                    $i++;
                    $allocateds['set_total_opd'] = array_sum($set_total_opd);
                    $allocateds['set_total_employee_opd'] = array_sum($set_total_employee_opd);
                    $allocated_amounts[] = $allocated;
                }
                $set_total_opd = array_sum($set_total_opd);
                return view('opdPayment.index', compact('opdpaymentss', 'filterYear','grandTotal','set_total_opd','set_total_employee_opd'));
            }
            $employees  = OPDPayment::where('created_by', \Auth::user()->creatorId())
//                ->groupBy('employee_id')
                ->whereYear('date',$currentyear);
            $employees = $employees->get();
            $opdpaymentss        = [];
            $i = 0;
            $grandTotal = array();
            foreach($employees as $opdPayment)
            {
                $opdpaymnet['id']          = $opdPayment->id;
                $opdpaymnet['employee_id'] = $opdPayment->employee_id;
                $opdpaymnet['name']    = $opdPayment->name;
                $opdpaymnet['totalAmount']    = $opdPayment->totalAmount;
                $opdpaymnet['amount']    = $opdPayment->amount;
                $opdpaymnet['date']    = $opdPayment->date;
                $opdpaymnet['attachment']    = $opdPayment->attachment;
                $grandTotal[] = $opdPayment['amount'];
                $i++;
                $empEobi['amount'] = array_sum($grandTotal);
                $opdpaymentss[] = $opdpaymnet;
            }
//            dd($opdpaymentss);
            $grandTotal = array_sum($grandTotal);
            $starting_year = date('Y', strtotime('-5 year'));
            $ending_year   = date('Y', strtotime('+5 year'));
            $filterYear['starting_year'] = $starting_year;
            $filterYear['ending_year']   = $ending_year;
            $filterYear = OPDPayment::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();
            $allocated_amount  = AllocatedAmount::query()
                ->select('id as pro_id','allocated_amounts.*',
                    DB::raw('SUM(allocated_amounts.set_total_opd) as set_total_opd'),
                    DB::raw('SUM(allocated_amounts.set_total_employee_opd) as set_total_employee_opd'))
                ->where('allocated_amounts.created_by', \Auth::user()->creatorId())
                ->whereYear('year',$currentyear)->get()->toArray();

            $set_total_opd = array();
            $set_total_employee_opd = array();
            $allocated_amounts    = [];
            $i = 0;
            foreach($allocated_amount as $allocated)
            {
                $allocateds['id']  = $allocated['id'];
                $allocateds['set_total_opd']  = $allocated['set_total_opd'];
                $allocateds['set_total_employee_opd'] = $allocated['set_total_employee_opd'];
                $set_total_opd[] = $allocated['set_total_opd'];
                $set_total_employee_opd[] = $allocated['set_total_employee_opd'];
                $i++;
                $allocateds['set_total_opd'] = array_sum($set_total_opd);
                $allocateds['set_total_employee_opd'] = array_sum($set_total_employee_opd);
                $allocated_amounts[] = $allocated;
            }
            $set_total_opd = array_sum($set_total_opd);
            $set_total_employee_opd = array_sum($set_total_employee_opd);
            return view('opdPayment.index', compact('opdpaymentss', 'filterYear','grandTotal','set_total_opd','set_total_employee_opd'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


    }
    public function opdStatus(Request $request)
    {
        $currentyear = Carbon::now()->year;
        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {
                $current = $request->month."-1";
                $currentDate = date('m', strtotime($current));
                $opd_employees = Employee::select(
                    DB::raw("employees.id"),
                    DB::raw("employees.name"),
                    DB::raw("o_p_d_payments.amount"),
                    DB::raw("o_p_d_payments.date"),
                    DB::raw("o_p_d_payments.id as opd_id"),
                    DB::raw("(SUM(amount)) as total_pf_amount")
                )

                    ->rightJoin('o_p_d_payments', 'o_p_d_payments.employee_id', '=', 'employees.id')
                    ->orderBy('employees.name','ASC')
                    ->groupBy('employees.name')
                    ->whereMonth('o_p_d_payments.date',$currentDate)
                    ->get()->toArray();
                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                $opd_employee= [];
                foreach($opd_employees as $opdEmployee)
                {
//                dd($opdEmployee);
                    $employeeLeave['id'] = $opdEmployee['id'];
                    $employeeLeave['name'] = $opdEmployee['name'];
                    $employeeLeave['amount'] = $opdEmployee['amount'];
                    $employeeLeave['date'] = $opdEmployee['date'];
                    $employeeLeave['opd_id'] = $opdEmployee['opd_id'];

                    $grandTotal[] = $opdEmployee['amount'];
                    $grandTotalEmployee[] = $opdEmployee['total_pf_amount'];
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $employeeLeave['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $empEobi['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $opd_employee[] = $opdEmployee;
                }

                $grandTotal = array_sum(($grandTotal));
                $grandTotalEmployee = array_sum(($grandTotalEmployee));

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('opdPayment.opd_payment_status', compact('opd_employee', 'filterYear','grandTotal','grandTotalEmployee'));

            }
            elseif(!isset($request->type))
            {
                $monthYear = date('Y-m');
                $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                $filterYear['type']          = __('Monthly');
            }
            if($request->type == 'yearly' && !empty($request->year))
            {
                $opd_employees = Employee::select(
                    DB::raw("employees.id"),
                    DB::raw("employees.name"),
                    DB::raw("o_p_d_payments.amount"),
                    DB::raw("o_p_d_payments.date"),
                    DB::raw("o_p_d_payments.id as opd_id"),
                    DB::raw("(SUM(amount)) as total_pf_amount")
                )
                    ->rightJoin('o_p_d_payments', 'o_p_d_payments.employee_id', '=', 'employees.id')
                    ->orderBy('employees.name','ASC')
                    ->groupBy('employees.name')
                    ->whereYear('o_p_d_payments.date',$request->year)
                    ->get()->toArray();

                $grandTotalEmployee = array();
                $i = 0;
                $grandTotal = array();
                foreach($opd_employees as $opdEmployee)
                {
                    $employeeLeave['id'] = $opdEmployee['id'];
                    $employeeLeave['name'] = $opdEmployee['name'];
                    $employeeLeave['amount'] = $opdEmployee['amount'];
                    $employeeLeave['date'] = $opdEmployee['date'];
                    $employeeLeave['opd_id'] = $opdEmployee['opd_id'];

                    $grandTotal[] = $opdEmployee['amount'];
                    $grandTotalEmployee[] = $opdEmployee['total_pf_amount'];
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $employeeLeave['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $i++;
                    $empEobi['grand_total_pf'] = array_sum($grandTotal);
                    $empEobi['grand_total_employee'] = array_sum($grandTotalEmployee);
                    $opd_employee[] = $opdEmployee;
                }
                $grandTotal = array_sum(($grandTotal));
                $grandTotalEmployee = array_sum(($grandTotalEmployee));

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('opdPayment.opd_payment_status', compact('opd_employee', 'filterYear','grandTotal','grandTotalEmployee'));

            }
            $opd_employees = Employee::select(
                DB::raw("employees.id"),
                DB::raw("employees.name"),
                DB::raw("o_p_d_payments.amount"),
                DB::raw("o_p_d_payments.date"),
                DB::raw("o_p_d_payments.id as opd_id"),
                DB::raw("(SUM(amount)) as total_pf_amount")
             )
                ->rightJoin('o_p_d_payments', 'o_p_d_payments.employee_id', '=', 'employees.id')
                ->orderBy('employees.name','ASC')
                ->groupBy('employees.name')
                ->whereYear('o_p_d_payments.date',$currentyear)
                ->get()->toArray();
              $opd_employee  = [];
            $grandTotalEmployee = array();
            $i = 0;
            $grandTotal = array();
            foreach($opd_employees as $opdEmployee)
            {

                $employeeLeave['id'] = $opdEmployee['id'];
                $employeeLeave['name'] = $opdEmployee['name'];
                $employeeLeave['amount'] = $opdEmployee['amount'];
                $employeeLeave['date'] = $opdEmployee['date'];
                $employeeLeave['opd_id'] = $opdEmployee['opd_id'];

                $grandTotal[] = $opdEmployee['amount'];
                $grandTotalEmployee[] = $opdEmployee['total_pf_amount'];
                $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                $employeeLeave['grand_total_employee'] = array_sum($grandTotalEmployee);
                $i++;
                $empEobi['grand_total_pf'] = array_sum($grandTotal);
                $empEobi['grand_total_employee'] = array_sum($grandTotalEmployee);
                $opd_employee[] = $opdEmployee;
            }
            $grandTotal = array_sum(($grandTotal));

            $grandTotalEmployee = array_sum(($grandTotalEmployee));

            $starting_year = date('Y', strtotime('-5 year'));
            $ending_year   = date('Y', strtotime('+5 year'));
            $filterYear['starting_year'] = $starting_year;
            $filterYear['ending_year']   = $ending_year;
            $filterYear = OPDPayment::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();
            return view('opdPayment.opd_payment_status', compact('opd_employee', 'filterYear','grandTotal','grandTotalEmployee'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function opdStatusDetails(Request $request)
    {

        $currentyear = Carbon::now()->year;

        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {

                $currentDate = $request->month."-1";
                $currentDate = date('m', strtotime($currentDate));
                $opd_details = OPDPayment::select(
                    DB::raw("employee_id"),
                    DB::raw("id"),
                    DB::raw("name"),
                    DB::raw("date"),
                    DB::raw("amount"),
                    DB::raw("MONTHNAME(o_p_d_payments.date) as month_name"),
                    DB::raw("description")
                )
                    ->whereYear('date', date('Y'))
                    ->orderBy('date')
                    ->whereMonth('date',$currentDate)
                    ->where('employee_id',request('id'))
                    ->get()
                    ->toArray();
                $opd_detail = [];
                $i = 0;
                $grandTotal = array();
                foreach($opd_details as $employee)
                {
                    $employeeLeave['id'] = $employee['id'];
                    $employeeLeave['name'] = $employee['name'];
                    $employeeLeave['month_name'] = $employee['month_name'];
                    $employeeLeave['date'] = $employee['date'];
                    $employeeLeave['description'] = $employee['description'];
                    $employeeLeave['total_pf_amount'] = $employee['amount'];
                    $grandTotal[] = $employeeLeave['total_pf_amount'];
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $i++;
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);

                    $opd_detail[] = $employee;

                }

                $grandTotal = array_sum($grandTotal);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('opdPayment.opd_payment_status_details', compact('opd_detail', 'filterYear','grandTotal'));

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
                $filterYear['type']          = __('Yearly');
                $opd_details = OPDPayment::select(
                    DB::raw("employee_id"),
                    DB::raw("id"),
                    DB::raw("name"),
                    DB::raw("date"),
                    DB::raw("amount"),
                    DB::raw("MONTHNAME(o_p_d_payments.date) as month_name"),
                    DB::raw("description")
                )
                    ->whereYear('date', date('Y'))
                    ->orderBy('date')
                    ->whereYear('date',$request->year)
                    ->where('employee_id',request('id'))
                    ->get()
                    ->toArray();
                $opd_detail = [];
                $i = 0;
                $grandTotal = array();
                foreach($opd_details as $employee)
                {
                    $employeeLeave['id'] = $employee['id'];
                    $employeeLeave['name'] = $employee['name'];
                    $employeeLeave['month_name'] = $employee['month_name'];
                    $employeeLeave['date'] = $employee['date'];
                    $employeeLeave['description'] = $employee['description'];
                    $employeeLeave['total_pf_amount'] = $employee['amount'];
                    $grandTotal[] = $employeeLeave['total_pf_amount'];
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                    $i++;
                    $employeeLeave['grand_total_pf'] = array_sum($grandTotal);

                    $opd_detail[] = $employee;

                }

                $grandTotal = array_sum($grandTotal);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('opdPayment.opd_payment_status_details', compact('opd_detail', 'filterYear','grandTotal'));

            }

            $opd_details = OPDPayment::select(
                    DB::raw("employee_id"),
                    DB::raw("id"),
                    DB::raw("name"),
                    DB::raw("date"),
                    DB::raw("amount"),
                    DB::raw("MONTHNAME(o_p_d_payments.date) as month_name"),
                    DB::raw("description")
                )
                ->whereYear('date', date('Y'))
                ->orderBy('date')
                ->whereYear('date',$currentyear)
                ->where('employee_id',request('id'))
                ->get()
                ->toArray();

            $opd_detail = [];
            $i = 0;
            $grandTotal = array();
            foreach($opd_details as $employee)
            {
                $employeeLeave['id'] = $employee['id'];
                $employeeLeave['name'] = $employee['name'];
                $employeeLeave['month_name'] = $employee['month_name'];
                $employeeLeave['date'] = $employee['date'];
                $employeeLeave['description'] = $employee['description'];
                $employeeLeave['total_pf_amount'] = $employee['amount'];
                $grandTotal[] = $employeeLeave['total_pf_amount'];
                $employeeLeave['grand_total_pf'] = array_sum($grandTotal);
                $i++;
                $employeeLeave['grand_total_pf'] = array_sum($grandTotal);

                $opd_detail[] = $employee;

            }
             $grandTotal = array_sum($grandTotal);

            $starting_year = date('Y', strtotime('-5 year'));
            $ending_year   = date('Y', strtotime('+5 year'));
            $filterYear['starting_year'] = $starting_year;
            $filterYear['ending_year']   = $ending_year;
            $filterYear = OPDPayment::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();
            return view('opdPayment.opd_payment_status_details', compact('opd_detail', 'filterYear','grandTotal'));
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
        ->leftJoin('o_p_d_payments', 'o_p_d_payments.employee_id', '=', 'employees.id')->groupBy('employees.id')->get()->toArray();
        
        return view('opdPayment.create', compact('employee'));
    }

    public function createAllocatedAmount()
    {
        return view('opdPayment.create-allocated-amount');
    }
    public function storeAllocatedAmount(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
                'set_total_opd' => 'required',
                'set_total_employee_opd' => 'required',
                'year' => 'required',

            ]
        );
        $allocatedAmount = new AllocatedAmount();
        $allocatedAmount->set_total_opd  = $request->set_total_opd;
        $allocatedAmount->set_total_employee_opd     = $request->set_total_employee_opd;
        $allocatedAmount->year = $request->year;
        $allocatedAmount->created_by     = \Auth::user()->creatorId();
        $allocatedAmount->save();
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        return redirect()->back()->with('success', __('Allocated Amount successfully created.'));
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
            $allocated_amounts  = AllocatedAmount::query()
            ->select('id as pro_id','allocated_amounts.*',
                DB::raw('SUM(allocated_amounts.set_total_opd) as set_total_opd'),
                DB::raw('SUM(allocated_amounts.set_total_employee_opd) as set_total_employee_opd'))
                ->where('allocated_amounts.created_by', \Auth::user()->creatorId())
                ->whereYear('year',$request->date)->get()->toArray();

            $opdPayment  = OPDPayment::query()
            ->select('id as pro_id','o_p_d_payments.*',
                DB::raw('SUM(o_p_d_payments.amount) as amount'),
                DB::raw('(o_p_d_payments.date)'))
               ->where('employee_id', $request->employee_id)
                ->whereYear('date',$allocated_amounts[0]['year'])
                ->first();
//dd($opdPayment);
          $allocatedYear = date('Y', strtotime($allocated_amounts[0]['year']));
          $OPdyear = date('Y', strtotime( $opdPayment['date']));

            if(empty($opdPayment['amount'])){
                $employeeTotalAmount = $request->amount;
            }else{
                $employeeTotalAmount = $request->amount+$opdPayment['amount'];
            }

//            if ($allocatedYear == $OPdyear){
//
//            }
//        dd($OPdyear);
            foreach($allocated_amounts as $totalAmount) {
             
                if ($totalAmount['set_total_employee_opd'] <  $employeeTotalAmount){
                    return redirect()->back()->with('error', __('Sorry ! your OPD LIMIT exceeded.'));
                }else{
                $employeeName =  Employee::where('id', $request->employee_id)->first();

                $opdPayment = new OPDPayment();
                $opdPayment->employee_id  = $request->employee_id;
                $opdPayment->name    = $employeeName['name'];
                $opdPayment->amount     = $request->amount;
                $opdPayment->date = $request->date;
                $opdPayment->description = $request->description;
                $opdPayment->created_by     = \Auth::user()->creatorId();
                $opdPayment->save();
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                if($request->hasFile('attachment'))
                {
                    $filenameWithExt = $request->file('attachment')->getClientOriginalName();
                    $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension       = $request->file('attachment')->getClientOriginalExtension();
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    $dir        = storage_path('uploads/opdFile');
                    $image_path = $dir . $filenameWithExt;

                    if(File::exists($image_path))
                    {
                        File::delete($image_path);
                    }
                    if(!file_exists($dir))
                    {
                        mkdir($dir, 0777, true);
                    }
                    $image = $request->file('attachment');
                    $path =  $image->move(public_path('/uploads/opdFile'),$fileNameToStore);
//            $path = ->storeAs('uploads/', $fileNameToStore);
                    $opd_Payment = OPDPayment::where('id',$opdPayment->id)->first();

                    if(!empty($opd_Payment))
                    {
                        $opd_Payment->attachment = $fileNameToStore;
                        $opd_Payment->save();
                    }
                }
                return redirect()->back()->with('success', __('OPD Payment successfully created.'));
                }
            }



    }
    public function opdpaymentDetails(Request $request)
    {
        $currentyear = Carbon::now()->year;
        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {

                $currentDate = $request->month."-1";
                $currentDate = date('m', strtotime($currentDate));
                $employees  = OPDPayment::
                where('o_p_d_payments.created_by', \Auth::user()->creatorId())->
                whereMonth('date',$currentDate);
                $employees = $employees->get();


                $opdpaymentss        = [];
                $i = 0;
                $grandTotal = array();
                foreach($employees as $opdPayment)
                {
                    $opdpaymnet['id']          = $opdPayment->id;
                    $opdpaymnet['employee_id'] = $opdPayment->employee_id;
                    $opdpaymnet['name']    = $opdPayment->name;
                    $opdpaymnet['amount']    = $opdPayment->amount;
                    $opdpaymnet['date']    = $opdPayment->date;
                    $opdpaymnet['attachment']    = $opdPayment->attachment;
                    $employeeE['amount'] = $opdPayment['amount'];

                    $grandTotal[] = $opdPayment['amount'];
                    $i++;
                    $empEobi['amount'] = array_sum($grandTotal);
                    $opdpaymentss[] = $opdpaymnet;
                }
                $grandTotal = array_sum($grandTotal);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('opdPayment.index', compact('opdpaymentss', 'filterYear','grandTotal'));
            }
            elseif(!isset($request->type))
            {
                $monthYear = date('Y-m');
                $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                $filterYear['type']          = __('Monthly');
            }
            if($request->type == 'yearly' && !empty($request->year))
            {
                $employees  = OPDPayment::query()
                    ->select('employee_id as pro_id','o_p_d_payments.*',
                        DB::raw('SUM(o_p_d_payments.amount) as totalAmount'))->
                    where('o_p_d_payments.created_by', \Auth::user()->creatorId())->
                    whereYear('date',$request->year);
                $employees = $employees->get();
                $opdpaymentss        = [];
                $i = 0;
                $grandTotal = array();
                foreach($employees as $opdPayment)
                {
                    $opdpaymnet['id']          = $opdPayment->id;
                    $opdpaymnet['employee_id'] = $opdPayment->employee_id;
                    $opdpaymnet['name']    = $opdPayment->name;
                    $opdpaymnet['amount']    = $opdPayment->amount;
                    $opdpaymnet['totalAmount']    = $opdPayment->totalAmount;
                    $opdpaymnet['date']    = $opdPayment->date;
                    $opdpaymnet['attachment']    = $opdPayment->attachment;
                    $employeeE['amount'] = $opdPayment['amount'];
                    $grandTotal[] = $opdPayment['amount'];
                    $i++;
                    $empEobi['amount'] = array_sum($grandTotal);
                    $opdpaymentss[] = $opdpaymnet;
                }
                $grandTotal = array_sum($grandTotal);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('opdPayment.index', compact('opdpaymentss', 'filterYear','grandTotal'));

            }

                $employees  = OPDPayment::where('created_by', \Auth::user()->creatorId())->
                whereYear('date',$currentyear)->
                where('employee_id','=',request('id'));
                $employees = $employees->get();

//                dd($employees);
                $opdpaymentss        = [];
                $i = 0;
                $grandTotal = array();
                foreach($employees as $opdPayment)
                {
                    $opdpaymnet['id']          = $opdPayment->id;
                    $opdpaymnet['employee_id'] = $opdPayment->employee_id;
                    $opdpaymnet['name']    = $opdPayment->name;
                    $opdpaymnet['amount']    = $opdPayment->amount;
                    $opdpaymnet['date']    = $opdPayment->date;
                    $opdpaymnet['attachment']    = $opdPayment->attachment;
                    $employeeE['amount'] = $opdPayment['amount'];

                    $grandTotal[] = $opdPayment['amount'];
                    $i++;
                    $empEobi['amount'] = array_sum($grandTotal);
                    $opdpaymentss[] = $opdpaymnet;
                }

                $grandTotal = array_sum($grandTotal);

                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
            $filterYear = OPDPayment::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();
                return view('opdPayment.opdPayment', compact('opdpaymentss', 'filterYear','grandTotal'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function AllocatedAmount(Request $request)
    {

        $currentyear = Carbon::now()->year;

        if(\Auth::user()->can('manage report'))
        {
            if($request->type == 'monthly' && !empty($request->month))
            {
                $currentDate = $request->month."-1";
                $currentDate = date('m', strtotime($currentDate));
                $employees  = OPDPayment::
                where('o_p_d_payments.created_by', \Auth::user()->creatorId())->
                whereMonth('date',$currentDate);
                $employees = $employees->get();
                $opdpaymentss        = [];
                $i = 0;
                $grandTotal = array();
                foreach($employees as $opdPayment)
                {
                    $opdpaymnet['id']          = $opdPayment->id;
                    $opdpaymnet['employee_id'] = $opdPayment->employee_id;
                    $opdpaymnet['name']    = $opdPayment->name;
                    $opdpaymnet['amount']    = $opdPayment->amount;
                    $opdpaymnet['date']    = $opdPayment->date;
                    $opdpaymnet['attachment']    = $opdPayment->attachment;
                    $employeeE['amount'] = $opdPayment['amount'];

                    $grandTotal[] = $opdPayment['amount'];
                    $i++;
                    $empEobi['amount'] = array_sum($grandTotal);
                    $opdpaymentss[] = $opdpaymnet;
                }
                $grandTotal = array_sum($grandTotal);
                $starting_year = date('Y', strtotime('-5 year'));
                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
                $filterYear = OPDPayment::select(
                    'date'
                )
                    ->groupBy(DB::raw("YEAR(date)"))
                    ->get()
                    ->toArray();
                return view('opdPayment.index', compact('opdpaymentss', 'filterYear','grandTotal'));
            }
            elseif(!isset($request->type))
            {
                $allocatedAmount  = AllocatedAmount::where('created_by', \Auth::user()->creatorId())->get();

                $allocatedAmounts        = [];
                $i = 0;
                $setTotalEmployeeOpd = array();
                $grandTotalAmount = array();
                foreach($allocatedAmount as $allocated)
                {
                    $allocated['id']          = $allocated->id;
                    $allocated['set_total_opd'] = $allocated->set_total_opd;
                    $allocated['set_total_employee_opd']    = $allocated->set_total_employee_opd;
                    $allocated['year']    = $allocated->year;
                    $grandTotalAmount[] = $allocated['set_total_opd'];
                    $setTotalEmployeeOpd[] = $allocated['set_total_employee_opd'];
                    $i++;
                    $allocated['set_total_opd_total'] = array_sum($grandTotalAmount);
                    $allocated['set_total_employee_opd_total'] = array_sum($setTotalEmployeeOpd);
                    $allocatedAmounts[] = $allocated;
                }
               
                $grandTotalAmount = array_sum($grandTotalAmount);
                $setTotalEmployeeOpd = array_sum($setTotalEmployeeOpd);

                $filterYear = AllocatedAmount::select(
                    'year'
                )
                    ->groupBy(DB::raw("YEAR(year)"))
                    ->get()
                    ->toArray();

                return view('opdPayment.allocated-amount', compact('allocatedAmounts', 'filterYear','grandTotalAmount','setTotalEmployeeOpd'));
            }

            if($request->type == 'yearly' && !empty($request->year))
            {

                $allocatedAmount  = AllocatedAmount::where('created_by', \Auth::user()->creatorId())
                    ->whereYear('year',$request->year)
                    ->get();

                $allocatedAmounts        = [];
                $i = 0;
                $setTotalEmployeeOpd = array();
                $grandTotalAmount = array();
                foreach($allocatedAmount as $allocated)
                {
                    $allocated['id']          = $allocated->id;
                    $allocated['set_total_opd'] = $allocated->set_total_opd;
                    $allocated['set_total_employee_opd']    = $allocated->set_total_employee_opd;
                    $allocated['year']    = $allocated->year;
                    $grandTotalAmount[] = $allocated['set_total_opd'];
                    $setTotalEmployeeOpd[] = $allocated['set_total_employee_opd'];
                    $i++;
                    $allocated['set_total_opd'] = array_sum($grandTotalAmount);
                    $allocated['set_total_employee_opd'] = array_sum($setTotalEmployeeOpd);
                    $allocatedAmounts[] = $allocated;
                }

                $grandTotalAmount = array_sum($grandTotalAmount);
                $setTotalEmployeeOpd = array_sum($setTotalEmployeeOpd);

                $filterYear = AllocatedAmount::select(
                    'year'
                )
                    ->groupBy(DB::raw("YEAR(year)"))
                    ->get()
                    ->toArray();

                return view('opdPayment.allocated-amount', compact('allocatedAmounts', 'filterYear','grandTotalAmount','setTotalEmployeeOpd'));
            }

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }


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
    public function destroyAllocatedAmount($id)
    {

        if(request('id'))
        {
            DB::table('allocated_amounts')->where('id', request('id'))->delete();
            return redirect('allocated-amount')->with('success', __('Allocated Amount Successfully Deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
        if(request('id'))
            {
                DB::table('o_p_d_payments')->where('id', request('id'))->delete();
                return redirect()->route('opd-payment.index')->with('success', __('OPD Payment successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
    }
}
