<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidentFoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provident_founds', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->integer('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('employee_amount')->nullable();
            $table->string('employee_date')->nullable();
            $table->string('employer_amout')->nullable();
            $table->string('employer_date')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('provident_founds');
    }
}
