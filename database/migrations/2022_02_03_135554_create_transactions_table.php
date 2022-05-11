<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('userId');
            $table->string('txn_id');
            $table->string('depositId');
            $table->string('address');
            $table->string('amount');
            $table->string('timeout');
            $table->string('confirms_needed');
            $table->string('checkout_url');
            $table->string('status_url');
            $table->string('qrcode_url');
            $table->float('status');
            $table->string('status_text');
            $table->string('type');
            $table->string('coin');
            $table->float('amount');
            $table->string('amountf');
            $table->float('received');
            $table->string('receivedf');
            $table->float('recv_confirms');
            $table->string('payment_address');
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
        Schema::dropIfExists('transactions');
    }
}
