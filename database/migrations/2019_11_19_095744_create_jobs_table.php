<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('form_no');
            $table->dateTime('request_date');
            $table->string('request_by');
            $table->string('request_office');
            $table->string('others')->nullable();
            $table->string('findings')->nullable();
            $table->string('remarks')->nullable();
            $table->string('service_by')->nullable();
            $table->dateTime('acted_date')->nullable();
            $table->dateTime('completed_date')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('jobs');
    }
}
