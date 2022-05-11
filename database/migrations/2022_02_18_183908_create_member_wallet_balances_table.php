<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberWalletBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_wallet_balances', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->string('userId')->unique()->index();
            $table->float('cash_balance');
            $table->float('investment');
            $table->float('investforother');
            $table->float('transfertoother');
            $table->float('income_amount');
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
        Schema::dropIfExists('member_wallet_balances');
    }
}
