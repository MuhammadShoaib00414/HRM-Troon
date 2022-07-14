<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttandanceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attandance_data', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->string('date')->nullable();
            $table->string('status')->nullable();
            $table->string('clock_in')->nullable();
            $table->string('clock_out')->nullable();
            $table->string('late')->nullable();
            $table->string('early_leaving')->nullable();
            $table->string('overtime')->nullable();
            $table->string('total_rest')->nullable();
            $table->string('company_start_time')->nullable();
            $table->string('company_end_time')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('attandance_data');
    }
}
