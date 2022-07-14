<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeTax;
use App\Models\PaySlip;

use DB;
use Carbon\Carbon;
class EmpTaxController extends Controller
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
                    $employeeTaxs  = EmployeeTax::where('created_by', \Auth::user()->creatorId())->
                    whereMonth('date', $currentDate)->get();
                    $emplTaxs  = [];
                    $i = 0;
                    $grandTotal = array();
                    foreach($employeeTaxs as $employeeTax)
                    {
                        $emplTax['id']          = $employeeTax->id;
                        $emplTax['employee_id'] = $employeeTax->employee_id;
                        $emplTax['name']    = $employeeTax->name;
                        $emplTax['tax_amount']    = $employeeTax->tax_amount;
                        $emplTax['date']    = $employeeTax->date;
                        $grandTotal[] = $employeeTax['tax_amount'];
                        $i++;
                        $emplTaxs[] = $employeeTax;
                    }
                    $grandTotal = array_sum($grandTotal);
                    $starting_year = date('Y', strtotime('-5 year'));
                    $ending_year   = date('Y', strtotime('+5 year'));
                    $filterYear['starting_year'] = $starting_year;
                    $filterYear['ending_year']   = $ending_year;
                    $filterYear = EmployeeTax::select(
                        'date'
                    )
                        ->groupBy(DB::raw("YEAR(date)"))
                        ->get()
                        ->toArray();
                    return view('empTax.index', compact('emplTaxs', 'filterYear','grandTotal'));
                }
                elseif(!isset($request->type))
                {
                    $month     = date('m');
                    $year      = date('Y');
                    $monthYear = date('Y-m');
                    $filterYear['dateYearRange'] = date('M-Y', strtotime($monthYear));
                    $filterYear['type']          = __('Monthly');
                }
                if($request->type == 'yearly' && !empty($request->year))
                {
                    $filterYear['dateYearRange'] = $request->year;
                    $filterYear['type']          = __('Yearly');
                    $employeeTaxs  = EmployeeTax::where('created_by', \Auth::user()->creatorId())->
                    whereYear('date', $request->year)->get();
                    $emplTaxs  = [];
                    $i = 0;
                    $grandTotal = array();
                    foreach($employeeTaxs as $employeeTax)
                    {
                        $emplTax['id']          = $employeeTax->id;
                        $emplTax['employee_id'] = $employeeTax->employee_id;
                        $emplTax['name']    = $employeeTax->name;
                        $emplTax['tax_amount']    = $employeeTax->tax_amount;
                        $emplTax['date']    = $employeeTax->date;
                        $grandTotal[] = $employeeTax['tax_amount'];
                        $i++;
                        $emplTaxs[] = $employeeTax;
                    }
                    $grandTotal = array_sum($grandTotal);
                    $starting_year = date('Y', strtotime('-5 year'));
                    $ending_year   = date('Y', strtotime('+5 year'));
                    $filterYear['starting_year'] = $starting_year;
                    $filterYear['ending_year']   = $ending_year;
                    $filterYear = EmployeeTax::select(
                        'date'
                    )
                        ->groupBy(DB::raw("YEAR(date)"))
                        ->get()
                        ->toArray();
                    return view('empTax.index', compact('emplTaxs', 'filterYear','grandTotal'));
                }
                $filterYear['type']          = __('Monthly');
                $filterYear['dateYearRange'] = date('M-Y');
//                $employeeTaxs  = EmployeeTax::where('created_by', \Auth::user()->creatorId())->
//                whereYear('date',$currentyear)->groupBy('employee_id')->get();
                 $employeeTaxs = EmployeeTax::query()
                 ->select('employee_taxes.*', DB::raw('SUM(employee_taxes.tax_amount) as tax_amount')
                 )->groupBy('employee_taxes.employee_id')->get();
                 
                  
                $emplTaxs  = [];
                $i = 0;
                $grandTotal = array();
                foreach($employeeTaxs as $employeeTax)
                {
                    $emplTax['id']          = $employeeTax->id;
                    $emplTax['employee_id'] = $employeeTax->employee_id;
                    $emplTax['name']    = $employeeTax->name;
                    $emplTax['tax_amount']    = $employeeTax->tax_amount;
                    $emplTax['date']    = $employeeTax->date;
                    $grandTotal[] = $employeeTax['tax_amount'];
                    $i++;
                    $emplTaxs[] = $employeeTax;
              }
                $grandTotal = array_sum($grandTotal);
                $starting_year = date('Y', strtotime('-5 year'));

                $ending_year   = date('Y', strtotime('+5 year'));
                $filterYear['starting_year'] = $starting_year;
                $filterYear['ending_year']   = $ending_year;
            $filterYear = EmployeeTax::select(
                'date'
            )
                ->groupBy(DB::raw("YEAR(date)"))
                ->get()
                ->toArray();

            return view('empTax.index', compact('emplTaxs', 'filterYear','grandTotal'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request ,$id)
    {
   
        $currentyear = Carbon::now()->year;
            if(\Auth::user()->can('manage report'))
            {

                if($request->type == 'monthly' && !empty($request->month))
                {

                    $currentDate = $request->month."-1";
                    $currentDate = date('m', strtotime($currentDate));
                    $employeetaxs = EmployeeTax::select(
                        DB::raw("(COUNT(*)) as count"),
                        DB::raw("(SUM(tax_amount)) as total_tax_amount"),
                        DB::raw("MONTHNAME(date) as month_name"),
                        DB::raw("id"),
                        DB::raw("employee_id"),
                        DB::raw("name"),
                        DB::raw("tax_amount"),
                        DB::raw("date")
                    )
                        ->whereMonth('date', $currentDate)
                        ->groupBy('month_name')
                        ->where('employee_id',request('id'))
                        ->get()
                        ->toArray();
                    $i = 0;
                    $grandTotal = array();
                    $employeeTaxs  = [];
                    foreach($employeetaxs as $employeetax)
                    {
                        $employeetaxs['id']          = $employeetax['id'];
                        $employeetaxs['employee_id'] = $employeetax['employee_id'];
                        $employeetaxs['name']    = $employeetax['name'];
                        $employeetaxs['tax_amount']    = $employeetax['tax_amount'];
                        $employeetaxs['total_tax_amount']    = $employeetax['total_tax_amount'];
                        $employeetaxs['date']    = $employeetax['date'];
                        $employeetaxs['month_name']    = $employeetax['month_name'];
                        $grandTotal[] = $employeetax['tax_amount'];
                        $i++;
                        $employeeTaxs[] = $employeetax;
                    }
                    $grandTotal = array_sum($grandTotal);
                    $starting_year = date('Y', strtotime('-5 year'));
                    $ending_year   = date('Y', strtotime('+5 year'));
                    $filterYear['starting_year'] = $starting_year;
                    $filterYear['ending_year']   = $ending_year;
                    $filterYear = EmployeeTax::select(
                        'date'
                    )
                        ->groupBy(DB::raw("YEAR(date)"))
                        ->get()
                        ->toArray();
                    return view('empTax.emptaxdetails', compact( 'employeeTaxs', 'filterYear','grandTotal'));

                }
                elseif(!isset($request->type))
                {
                    $filterYear['type']          = __('Monthly');
                    $filterYear['dateYearRange'] = date('M-Y');
                     $employeetaxs = EmployeeTax::select(
                        DB::raw("(COUNT(*)) as count"),
                        DB::raw("(SUM(tax_amount)) as total_tax_amount"),
                        DB::raw("MONTHNAME(date) as month_name"),
                        DB::raw("id"),
                        DB::raw("employee_id"),
                        DB::raw("name"),
                        DB::raw("tax_amount"),
                        DB::raw("date")
                    )
                    // ->whereYear('date',$currentyear)
                    ->groupBy('month_name')
                    ->where('employee_id',request('id'))
                    ->get()
                    ->toArray();

                    // dd($employeetaxs);
                    $i = 0;
                    $grandTotal = array();
                    $grandTotalamount = array();
                    $employeeTaxs  = [];
                    foreach($employeetaxs as $employeetax)
                    {
                        $employeetaxs['id']          = $employeetax['id'];
                        $employeetaxs['employee_id'] = $employeetax['employee_id'];
                        $employeetaxs['name']    = $employeetax['name'];
                        $employeetaxs['tax_amount']    = $employeetax['tax_amount'];
                        $employeetaxs['total_tax_amount']    = $employeetax['total_tax_amount'];
                        $employeetaxs['date']    = $employeetax['date'];
                        $employeetaxs['month_name']    = $employeetax['month_name'];
                        $grandTotal[] = $employeetax['tax_amount'];
                        $grandTotalamount[] = $employeetax['total_tax_amount'];

                        $i++;
                        $employeeTaxs[] = $employeetax;
                        $grandTotalamount[] = $grandTotalamount;
                  }
                    $grandTotal = array_sum($grandTotal);
                    $grandTotalamount = array_sum($grandTotalamount);

                  
                    $starting_year = date('Y', strtotime('-5 year'));
                    $ending_year   = date('Y', strtotime('+5 year'));
                    $filterYear['starting_year'] = $starting_year;
                    $filterYear['ending_year']   = $ending_year;
                    $filterYear = EmployeeTax::select(
                        'date'
                    )
                        ->groupBy(DB::raw("YEAR(date)"))
                        ->get()
                        ->toArray();
                    return view('empTax.emptaxdetails', compact( 'employeeTaxs', 'filterYear','grandTotal','grandTotalamount'));
                }
                if($request->type == 'yearly' && !empty($request->year))
                {
                    $filterYear['dateYearRange'] = $request->year;
                    $filterYear['type']          = __('Yearly');
                    $employeetaxs = EmployeeTax::select(
                        DB::raw("(COUNT(*)) as count"),
                        DB::raw("(SUM(tax_amount)) as total_tax_amount"),
                        DB::raw("MONTHNAME(date) as month_name"),
                        DB::raw("id"),
                        DB::raw("employee_id"),
                        DB::raw("name"),
                        DB::raw("tax_amount"),
                        DB::raw("date")
                    )
                        ->whereYear('date', $request->year)
                        ->groupBy('month_name')
                        ->where('employee_id',request('id'))
                        ->get()
                        ->toArray();
                    $i = 0;
                    $grandTotal = array();
                    $grandTotalamount = array();
                    $employeeTaxs  = [];
                    foreach($employeetaxs as $employeetax)
                    {
                        $employeetaxs['id']          = $employeetax['id'];
                        $employeetaxs['employee_id'] = $employeetax['employee_id'];
                        $employeetaxs['name']    = $employeetax['name'];
                        $employeetaxs['tax_amount']    = $employeetax['tax_amount'];
                        $employeetaxs['total_tax_amount']    = $employeetax['total_tax_amount'];
                        $employeetaxs['date']    = $employeetax['date'];
                        $employeetaxs['month_name']    = $employeetax['month_name'];
                        $grandTotal[] = $employeetax['tax_amount'];
                        $grandTotalamount[] = $employeetax['total_tax_amount'];
                        $i++;
                        $employeeTaxs[] = $employeetax;
                    }
                    $grandTotal = array_sum($grandTotal);
                    $grandTotalamount = array_sum($grandTotalamount);

                    $starting_year = date('Y', strtotime('-5 year'));
                    $ending_year   = date('Y', strtotime('+5 year'));
                    $filterYear['starting_year'] = $starting_year;
                    $filterYear['ending_year']   = $ending_year;
                    $filterYear = EmployeeTax::select(
                        'date'
                    )
                        ->groupBy(DB::raw("YEAR(date)"))
                        ->get()
                        ->toArray();
                    return view('empTax.emptaxdetails', compact( 'employeeTaxs', 'filterYear','grandTotal','grandTotalamount'));
                }
               
                
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
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
    public function destroy($id)
    {
        //
    }
}
