<?php

namespace App\Http\Controllers;
use App\Models\Provident;
use App\Models\Employee;
use App\Models\Loan;
use App\Models\LoanOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProvidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function providentCreate($id)
    {
        $employee = Employee::find($id);
      
        return view('provident.create', compact('employee'));
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
      
        // if(\Auth::user()->can('create provident'))
        // {
            
            $validator = \Validator::make(
                $request->all(), [
                                   'employee_id' => 'required',
                                    'title' => 'required',
                                    'employee_amount' => 'required',
                                   'employee_date' => 'required',
                                   'employer_amout' => 'required',
                                   'employer_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $provident = new Provident();
            $provident->employee_id    = $request->employee_id;
            $provident->title     = $request->title;

             $provident->employee_amount     = $request->employee_amount;
            $provident->employee_date = $request->employee_date;
            $provident->employer_amout   = $request->employer_amout;
            $provident->employer_date           = $request->employer_date;
            $provident->created_by     = \Auth::user()->creatorId();
            $provident->save();
            return redirect()->back()->with('success', __('Provident Fund successfully created.'));
        // }
        // else {
        //     return redirect()->back()->with('error', __('Permission denied.'));
        // }
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
    public function edit($provident)
    {
        $provident = Provident::find($provident);
       
        if(\Auth::user()->can('edit overtime'))
        {
            if($provident->created_by == \Auth::user()->creatorId())
            {
              
                return view('provident.edit', compact('provident'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
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
        $provident = Provident::find($request->provident_id);

          if($provident->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [

                                       'employee_amount' => 'required',
                                       'title' => 'required',
                                       'employee_date' => 'required',
                                       'employer_amout' => 'required',
                                       'employer_date' => 'required'
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $provident->title     = $request->title;
                $provident->employee_amount = $request->employee_amount;
                $provident->employee_date       = $request->employee_date;
                $provident->employer_amout      = $request->employer_amout;
                $provident->employer_date  = $request->employer_date;
               
                $provident->save();

                return redirect()->back()->with('success', __('Loan successfully updated.'));
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
    public function destroy(Provident $provident)
    {
     
        
     
           
            if($provident->created_by == \Auth::user()->creatorId())
            {
             
                $provident->delete();

                return redirect()->back()->with('success', __('Provident Found successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
  
}
