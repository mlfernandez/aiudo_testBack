<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('currency');
            $table->integer('amount_total');
            $table->integer('amount_paid');
            $table->integer('amount_due');
            $table->date('date_start');
            $table->integer('loan_term_month');
            $table->integer('interest_rate_month');
            $table->integer('monthly_payments');
            $table->foreignId("user_id")->references('id')->on('users');
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
        Schema::dropIfExists('loans');
    }
}
