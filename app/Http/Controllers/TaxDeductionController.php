<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\TaxDeduction;
class TaxDeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function taxCreate($id)
    {
         $employee = Employee::find($id);
        return view('tax.create', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
                               'title' => 'required',
                              'tax_amount' => 'required',
                               'tax_date' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $eobi = new TaxDeduction();
        $eobi->employee_id    = $request->employee_id;
        $eobi->title    = $request->title;
        $eobi->tax_amount     = $request->tax_amount;
        $eobi->tax_date = $request->tax_date;
        $eobi->created_by     = \Auth::user()->creatorId();
        $eobi->save();
        return redirect()->back()->with('success', __('Tax successfully created.'));
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
    public function edit($tax)
    {
        $tax = TaxDeduction::find($tax);
        // dd($eobi);
       
            if($tax->created_by == \Auth::user()->creatorId())
            {
              
                return view('tax.edit', compact('tax'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
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
        $tax = TaxDeduction::find($request->employee_id);

        if($tax->created_by == \Auth::user()->creatorId())
          {
              $validator = \Validator::make(
                  $request->all(), [

                      'title' => 'required',
                    'tax_amount' => 'required',
                    'tax_date' => 'required',
                                 ]
              );
              if($validator->fails())
              {
                  $messages = $validator->getMessageBag();

                  return redirect()->back()->with('error', $messages->first());
              }
              $tax->title = $request->title;
              $tax->tax_amount = $request->tax_amount;
              $tax->tax_date       = $request->tax_date;
              $tax->created_by     = \Auth::user()->creatorId();
             
              $tax->save();

              return redirect()->back()->with('success', __('Tax successfully updated.'));
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
    public function destroy(TaxDeduction $tax)
    {
    //    dd($tax);
       
        if($tax->created_by == \Auth::user()->creatorId())
        {
         
            $tax->delete();

            return redirect()->back()->with('success', __('Tax successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
