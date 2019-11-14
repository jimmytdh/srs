<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BorrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');
            $table->dateTime('date_borrowed');
            $table->string('user_borrowed');
            $table->string('remarks_borrowed')->nullable();
            $table->dateTime('date_returned');
            $table->string('user_returned');
            $table->string('remarks_returned')->nullable();
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
        Schema::table('borrow', function (Blueprint $table) {
            Schema::dropIfExists('borrow');
        });
    }
}
