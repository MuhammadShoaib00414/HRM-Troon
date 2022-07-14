@extends('layouts.admin')

@section('page-title')
    {{__('Employee')}}
@endsection

@section('action-button')
    <div class="all-button-box row d-flex justify-content-end">
        @can('edit employee')
            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6">
                <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}"
                   class="btn btn-xs btn-white btn-icon-only width-auto">
                    <i class="fa fa-edit"></i> {{ __('Edit') }}
                </a>
            </div>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Personal Detail')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('EmployeeId')}}</strong>
                                    <span>{{$employeesId}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Username')}}</strong>
                                    <span>{{$employee->name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('First Name')}}</strong>
                                    <span>{{$employee->fname}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Last Name')}}</strong>
                                    <span>{{$employee->lname}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('CNIC Number')}}</strong>
                                    <span>{{$employee->cnic}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Status')}}</strong>
                                    <span>{{$employee->status}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Gender')}}</strong>
                                    <span>{{$employee->gender}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Date of Birth')}}</strong>
                                    <span>{{\Auth::user()->dateFormat($employee->dob)}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Email')}}</strong>
                                    <span>{{$employee->email}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Religion')}}</strong>
                                    <span>{{$employee->religion}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Department')}}</strong>
                                    @if($employee->department)
                                        <span>{{$employee->department->name}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Designation')}}</strong>
                                    <span>{{$employee->nationality_id}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Phone')}}</strong>
                                    <span>{{$employee->phone}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Date Of Joining')}}</strong>
                                    <span>{{$employee->company_doj}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Profile Image')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">

                                @if($employee->profile_image)
                                    <img src="{{'/public/uploads/profile/'.$employee->profile_image }}" width="140"
                                         alt="">
                                @else
                                    <img src="/public/uploads/avatar/avatar.png" width="140" alt="" download title="">
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Professional Information')}}</h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Employer Name')}}</strong>
                                        <span>{{$employee->employer_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Designation')}}</strong>
                                        <span>{{$employee->pro_designation}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Start Date')}}</strong>
                                        <span>{{$employee->professional_start_date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('End Date')}}</strong>
                                        <span>{{$employee->professional_end_date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Experience Letter')}}</strong>
                                        @if($employee->experience_letter)

                                            <a href="{{ '/public/uploads/experienceLetter/'.$employee->experience_letter }}"
                                               download><i class="fa fa-download"> {{$employee->experience_letter }}</i></a>
                                        @else
                                            <div class="text-centers">
                                                No Document Type Added.!
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Reference Name')}}</strong>
                                        <span>{{$employee->reference_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Reference Number')}}</strong>
                                        <span>{{$employee->refeance_number}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Reference Email')}}</strong>
                                        <span>{{$employee->refeance_number}}</span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Education Information')}}</h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Insititution Name')}}</strong>
                                        <span>{{$employee->insititution_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm font-style">
                                        <strong>{{__('Start Date')}}</strong>
                                        <span>{{$employee->educational_start_date}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('End Date')}}</strong>
                                        <span>{{$employee->educational_start_date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Name of Degree')}}</strong>
                                        <span>{{$employee->name_degree}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Specialization')}}</strong>
                                        <span>{{$employee->specialization}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Degree Level')}}</strong>
                                        <span>{{$employee->degree_level}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Degree Copy')}}</strong>
                                        @if($employee->degree_copy)

                                            <a href="{{ '/public/uploads/degree/'.$employee->degree_copy }}" download><i
                                                        class="fa fa-download">  {{$employee->degree_copy }}</i></a>
                                        @else
                                            <div class="text-centers">
                                                No Document Type Added.!
                                            </div>
                                        @endif

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Document Detail')}}</h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                @php
                                    $employeedoc = $employee->documents()->pluck('document_value',__('document_id'));
                                @endphp
                                @if(!$documents->isEmpty())
                                    @foreach($documents as $key=>$document)
                                        <div class="col-md-12">
                                            <div class="info text-sm">
                                                <strong>{{$document->name }}</strong>
                                                <span><a href="{{ (!empty($employeedoc[$document->id])?asset(url('/public/uploads/document')).'/'.$employeedoc[$document->id]:'') }}"
                                                         target=""
                                                         download>{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-centers">
                                        No Document Type Added.!
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Contract Information')}}</h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Basic Salary')}}</strong>
                                        <span>{{$employee->basic_salary}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Hourly Rate')}}</strong>
                                        <span>{{$employee->hourly_rate}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Payslip Type')}}</strong>
                                        <span>{{$employee->salaries_type}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Leave Categories')}}</strong>
                                        <span>{{$employee->leave_type}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Contract Start Date')}}</strong>
                                        <span>{{$employee->contract_start_date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Contract End Date')}}</strong>
                                        <span>{{$employee->contract_end_date}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Reporting To')}}</strong>
                                        <span>{{$employee->reporting_to}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Office Timing')}}</strong>
                                        <span>{{$employee->office_time}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Note')}}</strong>
                                        <span>{{$employee->benefits_details}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Employment Status')}}</strong>
                                        <span>{{$employee->employment_status}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Department')}}</strong>
                                        <span>{{$employee->contract_department}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Designation')}}</strong>
                                        <span>{{$employee->contract_designation}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Contract Copy')}}</strong>
                                        @if($employee->contract_copy)
                                            <a download=""
                                               href="{{ '/public/uploads/contract/'.$employee->contract_copy }}"
                                               download><i class="fa fa-download"> {{$employee->contract_copy }}</i></a>
                                        @else
                                            <div class="text-centers">
                                                No Document Type Added.!
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-6 ">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Family Details')}}</h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Fathers Name')}}</strong>
                                        <span>{{$employee->father_name}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Mothers Name')}}</strong>
                                        <span>{{$employee->mother_name}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Marital Status')}}</strong>
                                        <span>{{$employee->marital_status}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Wife Name')}}</strong>
                                        <span>{{$employee->wife_name}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Wife Cnic')}}</strong>
                                        <span>{{$employee->wife_cnic}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Wife Date Of Birth')}}</strong>
                                        <span>{{$employee->wife_dob}}</span>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="info text-sm">
                                        <table class="table table-bordered" id="dynamicTable">
                                            @if($resultfamily)
                                                <tr>
                                                    <td>
                                                        <strong>{{__('Children Name')}}</strong>
                                                    </td>
                                                    <td><strong>{{__('Children DOB')}}</strong></td>
                                                    <td><strong>{{__('Children Gender')}}</strong></td>
                                                </tr>

                                                @foreach($resultfamily as $family)
                                                    <tr>
                                                        <td>
                                                            <div class="info text-sm">
                                                                <span>{{$family['name']}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info text-sm">
                                                                <span>{{$family['dob']}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="info text-sm">

                                                                @if($family['gender'] == 'f')
                                                                    <span>  Female  </span>
                                                                @else
                                                                    <span> Male </span>
                                                                @endif

                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </table>
                                    </div>
                                </div>


                            <!-- <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Branch')}}</strong>
                                    <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Department')}}</strong>
                                    <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Designation')}}</strong>
                                    <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Date Of Joining')}}</strong>
                                    <span>{{\Auth::user()->dateFormat($employee->company_doj)}}</span>
                                </div>
                            </div> -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="employee-detail-wrap">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">{{__('Emergency Contact')}}</h6>
                        </div>
                        <div class="card-body employee-detail-body">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="info text-sm">
                                        <strong>{{__('Full Name')}}</strong>
                                        <span>{{$employee->emergency_name}}</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Relationship')}}</strong>
                                        <span>{{$employee->emergency_relation}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class="info text-sm">
                                        <strong>{{__('Emergency Number')}}</strong>
                                        <span>{{$employee->emergency_number}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info text-sm">
                                        <strong>{{__('Blood Group')}}</strong>
                                        <span>{{$employee->blood_group}}</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="info text-sm">
                                        <strong>{{__('Emergency Address')}}</strong>
                                        <span>{{$employee->emergency_address}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Social Profile')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Facebook')}}</strong>
                                    <span>{{$employee->facebook}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Twitter')}}</strong>
                                    <span>{{$employee->twitter}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Google Plus')}}</strong>
                                    <span>{{$employee->google}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Linkedin In')}}</strong>
                                    <span>{{$employee->linkedin}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Assets')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="info text-sm">
                                    <table class="table table-bordered" id="dynamicTable">
                                        @if($resultArrayAssets )
                                            <tr>
                                                <td>
                                                    <strong>{{__('Device Name')}}</strong>
                                                </td>
                                                <td><strong>{{__('Device Details')}}</strong></td>

                                            </tr>

                                            @foreach($resultArrayAssets as $assets)
                                                <tr>
                                                    <td>
                                                        <div class="info text-sm">
                                                            <span>{{$assets['name']}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="info text-sm">
                                                            <span>{{$assets['details']}}</span>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-md-6 ">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Bank Account Detail')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Account Holder Name')}}</strong>
                                    <span>{{$employee->account_holder_name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Account Number')}}</strong>
                                    <span>{{$employee->account_number}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong>{{__('Bank Name')}}</strong>
                                    <span>{{$employee->bank_name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Bank Identifier Code')}}</strong>
                                    <span>{{$employee->bank_identifier_code}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Branch Location')}}</strong>
                                    <span>{{$employee->branch_location}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('Tax Payer Id')}}</strong>
                                    <span>{{$employee->tax_payer_id}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="employee-detail-wrap">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{__('Address')}}</h6>
                    </div>
                    <div class="card-body employee-detail-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('State / Province')}}</strong>
                                    <span>{{$employee->province}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__('City')}}</strong>
                                    <span>{{$employee->city}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong>{{__(' Postal Code')}}</strong>
                                    <span>{{$employee->zip_code}}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info text-sm">
                                    <strong>{{__('Present Address')}}</strong>
                                    <span>{{$employee->present_address}}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info text-sm">
                                    <strong>{{__('Permanent Address')}}</strong>
                                    <span>{{$employee->permanent_address}}</span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
