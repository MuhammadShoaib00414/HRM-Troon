<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\EOBI;

use Illuminate\Http\Request;

class EOBIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function eobiCreate($id)
    {
         $employee = Employee::find($id);
        return view('eobi.create', compact('employee'));
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
 
            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                   'employee_amount' => 'required',
                                   'employer_amount' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $eobi = new EOBI();
            $eobi->employee_id    = $request->employee_id;
            $eobi->title    = $request->title;
            $eobi->employee_amount     = $request->employee_amount;
            $eobi->employer_amount     = $request->employer_amount;
            $eobi->eobi_date = $request->eobi_date;
            $eobi->created_by     = \Auth::user()->creatorId();
            $eobi->save();
            return redirect()->back()->with('success', __('EOBI successfully created.'));
        
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
    public function edit($eobi)
    {
        $eobi = EOBI::find($eobi);
        // dd($eobi);
       
            if($eobi->created_by == \Auth::user()->creatorId())
            {
              
                return view('eobi.edit', compact('eobi'));
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
        // dd($request);
        $eobi = EOBI::find($request->eobi_id);

        if($eobi->created_by == \Auth::user()->creatorId())
          {
              $validator = \Validator::make(
                  $request->all(), [

                   
                    'employee_amount' => 'required',
                    'employer_amount' => 'required',
                                 ]
              );
              if($validator->fails())
              {
                  $messages = $validator->getMessageBag();

                  return redirect()->back()->with('error', $messages->first());
              }
              $eobi->title = $request->title;
              $eobi->employee_amount = $request->employee_amount;
              $eobi->employer_amount = $request->employer_amount;
              $eobi->eobi_date       = $request->eobi_date;
           
              $eobi->created_by     = \Auth::user()->creatorId();
              $eobi->save();

              return redirect()->back()->with('success', __('EOBI successfully updated.'));
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
    public function destroy(EOBI $eobi)
    {
        if($eobi->created_by == \Auth::user()->creatorId())
            {
             
                $eobi->delete();

                return redirect()->back()->with('success', __('EOBI successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        
    }
}
