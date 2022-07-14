<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_id');
            $table->date('date');
            $table->string('status');
            $table->string('clock_in');
            $table->string('clock_out');
            $table->time('late')->nullable();;
            $table->time('early_leaving')->nullable();;
            $table->time('overtime')->nullable();;
            $table->time('total_rest')->nullable();;
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
        Schema::dropIfExists('attendance_employees');
    }
}
