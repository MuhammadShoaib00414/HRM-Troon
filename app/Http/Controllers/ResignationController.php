<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Mail\ResignationSend;
use App\Models\Resignation;
use App\Models\User;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ResignationController extends Controller
{

    public function index()
    {
        if(\Auth::user()->can('manage resignation'))
        {
            if(Auth::user()->type == 'employee')
            {
                $emp          = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $resignations = Resignation::where('created_by', '=', \Auth::user()->creatorId())->where('employee_id', '=', $emp->id)->get();
            }
            else
            {
                $resignations = Resignation::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('resignation.index', compact('resignations'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create resignation'))
        {
            $employees = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('resignation.create', compact('employees'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
     
       
        if(\Auth::user()->can('create resignation'))
        {

            $validator = \Validator::make(
                $request->all(), [
                     'notice_date' => 'required',
                     'resignation_date' => 'required',
                     'resignationDocument' => 'required',
                   ]
            );
            try
                {
                 if($request->hasFile('resignationDocument')){
                 $document_files = [];
                   if($request->resignationDocument){
                        foreach($request->resignationDocument as $file)
                   {
                        $name = time().rand(1,100).'.'.$file->extension();
                        $file->move(public_path('/uploads/resignation'), $name);  
                        $document_files[] = $name;  
                    }
                }
                      $document_file = json_encode($document_files);
                   }else{
                       $document_file ='[""]';
                   }
                }
                catch(\Exception $e)
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
            }

           
            $resignation = new Resignation();
            $user        = \Auth::user();
            if($user->type == 'employee')
            {
                $employee   = Employee::where('user_id', $user->id)->first();
                $resignation->employee_id = $employee->id;
            }
            else
            {
                $resignation->employee_id = $request->employee_id;
            }

            if($request->disabledAccount == 'yes'){
                $employee  = Employee::where('id',$request->employee_id)->update(['status'=>'inactive']);              
            }else{
     
              $employee  = Employee::where('id',$request->employee_id)->update(['status'=>'active']);

            }
            
            // $resignation->employee_id = $employee->id;
            $resignation->notice_date      = $request->notice_date;
            $resignation->resignation_date = $request->resignation_date;
            $resignation->exit_interview = $request->exit_interview;
            $resignation->disabledAccount = $request->disabledAccount;
            $resignation->resignationDocument = $document_file;
            $resignation->description      = $request->description;
            $resignation->created_by       = \Auth::user()->creatorId();

            $resignation->save();
 
            $setings = Utility::settings();
            if($setings['employee_resignation'] == 1)
            {
                $employee           = Employee::find($resignation->employee_id);
                $resignation->name  = $employee->name;
                $resignation->email = $employee->email;
                try
                {
                    Mail::to($resignation->email)->send(new ResignationSend($resignation));
                }
                catch(\Exception $e)
                {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }


                $user           = User::find($employee->created_by);
                $resignation->name  = $user->name;
                $resignation->email = $user->email;
                try
                {
                    Mail::to($resignation->email)->send(new ResignationSend($resignation));
                }
                catch(\Exception $e)
                {
                    $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
                }

                return redirect()->route('resignation.index')->with('success', __('Resignation  successfully created.') . (isset($smtp_error) ? $smtp_error : ''));

            }

            return redirect()->route('resignation.index')->with('success', __('Resignation  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Resignation $resignation)
    {
        return redirect()->route('resignation.index');
    }

    public function edit(Resignation $resignation)
    {

        if(\Auth::user()->can('edit resignation'))
        {
            $employees = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            if($resignation->created_by == \Auth::user()->creatorId())
            {

                return view('resignation.edit', compact('resignation', 'employees'));
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

    public function update(Request $request, Resignation $resignation)
    {
    // dd($request->hasFile('resignationDocument'));

       
        if(\Auth::user()->can('edit resignation'))
        {
            if($resignation->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [

                                       'notice_date' => 'required',
                                       'resignation_date' => 'required',
                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                if(\Auth::user()->type != 'employee')
                {
                    $resignation->employee_id = $request->employee_id;
                }
        
                if($request->hasFile('resignationDocument')){
                    $document_files = [];
                    if($request->resignationDocument)
                    {
                        foreach($request->resignationDocument as $file)
                        {
                          
                            $name = time().rand(1,100).'.'.$file->extension();
                           $path =  $file->move(public_path('/uploads/resignation'), $name);  
                          
                            $document_files[] = $name;  
                        }
                    } 
                 
               }
               if($request->hasFile('resignationDocument')){
                $resignationDocuments = array_merge($request->resignation_old,$document_files);
              
               }else{
             
                  $resignationDocuments = $request->resignation_old;
               
               }
          
               $employee_document =  Resignation::where('employee_id',$request->employee_id)->update(['resignationDocument'=> json_encode($resignationDocuments)]); 
       
             
                if($request->disabledAccount == 'yes'){
                    $employee  = Employee::where('id',$request->employee_id)->update(['status'=>'inactive']);              
                }else{
         
                  $employee  = Employee::where('id',$request->employee_id)->update(['status'=>'active']);
    
                }
                // exit;
                $resignation->notice_date      = $request->notice_date;
                $resignation->resignation_date = $request->resignation_date;
                $resignation->exit_interview = $request->exit_interview;
                $resignation->disabledAccount = $request->disabledAccount;
                $resignation->description      = $request->description;

                $resignation->save();
               

                return redirect()->route('resignation.index')->with('success', __('Resignation successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Resignation $resignation)
    {
        if(\Auth::user()->can('delete resignation'))
        {
            if($resignation->created_by == \Auth::user()->creatorId())
            {
                $resignation->delete();

                return redirect()->route('resignation.index')->with('success', __('Resignation successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
