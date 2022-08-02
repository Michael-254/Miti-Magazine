<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMtnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mtns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('currency');
            $table->string('amount');
            $table->string('reference');
            $table->string('msisdn_id');
            $table->string('status')->default('unverified');
            $table->string('access_token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('token_type')->nullable();
            $table->string('txncd')->nullable();
            $table->string('product')->nullable();
            $table->string('expires_at')->nullable();
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
        Schema::dropIfExists('mtns');
    }
}
