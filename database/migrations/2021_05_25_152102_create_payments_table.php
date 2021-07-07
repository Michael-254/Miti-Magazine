<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('currency');
            $table->string('amount');
            $table->string('reference');
<<<<<<< HEAD
            $table->string('msisdn_id')->nullable();
            $table->string('msisdn_idnum')->nullable();
            $table->string('txncd')->nullable();
            $table->string('channel')->nullable();
=======
            $table->string('account')->nullable();
>>>>>>> 00ae468b01239cae3be82e00613cd7743551043c
            $table->string('status')->default('unverified');
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
        Schema::dropIfExists('payments');
    }
}
