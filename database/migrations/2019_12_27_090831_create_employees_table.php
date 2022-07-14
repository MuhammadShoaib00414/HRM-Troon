<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'employees', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->integer('user_id')->default('0');
            $table->string('name')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('cnic')->nullable();
            $table->string('status')->default('0');
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('religion')->nullable();
            $table->integer('nationality_id')->nullable();
            $table->integer('citizenship_id')->nullable();
            $table->integer('department_id')->default('0');
            $table->integer('designation_id')->default('0');
            $table->text('reference')->nullable();           
            $table->string('phone')->nullable();
            $table->text('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('wife_name')->nullable();
            $table->string('wife_cnic')->nullable();
            $table->string('wife_dob')->nullable();
            $table->text('children_name')->nullable();
            $table->string('children_dob')->nullable();
            $table->string('children_gender')->nullable();
            $table->text('emergency_name')->nullable();
            $table->text('emergency_relation')->nullable();
            $table->string('emergency_number')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('emergency_address')->nullable();
            $table->string('insititution_name')->nullable();
            $table->date('educational_start_date')->nullable();
            $table->date('educational_end_date')->nullable();
            $table->string('name_degree')->nullable();
            $table->string('specialization')->nullable();
            $table->string('degree_level')->nullable();
            $table->string('degree_copy')->nullable();
            $table->string('employer_name')->nullable();
            $table->string('pro_designation')->nullable();
            $table->date('professional_start_date')->nullable();
            $table->date('professional_end_date')->nullable();
            $table->string('experience_letter')->nullable();
            $table->string('reference_name')->nullable();
            $table->string('refeance_number')->nullable();
            $table->string('refeance_email')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_details',500)->nullable();;
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('google')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_identifier_code')->nullable();
            $table->string('branch_location')->nullable();
            $table->string('tax_payer_id')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->text('address')->nullable();
            
            $table->string('basic_salary')->nullable();
            $table->string('hourly_rate')->nullable();
            $table->string('salaries_type')->nullable();
            $table->string('leave_type')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            
            $table->string('reporting_to')->nullable();
            $table->string('office_time')->nullable();
            $table->string('benefits_details')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('contract_department')->nullable();
            $table->string('contract_designation')->nullable();
            $table->string('contract_copy')->nullable();

            $table->string('password')->nullable();
            $table->string('employee_id')->default('0');
            $table->integer('branch_id')->default('0');
            $table->string('company_doj')->nullable();
            $table->string('documents')->nullable();
            $table->integer('salary_type')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('is_active')->default('1');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
