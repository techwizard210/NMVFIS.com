<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateMemberLatestTxnInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_latest_txn_infos', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->string('userId');
            $table->string('txn_id');
            $table->dateTime('date');
            $table->float('funds_amount');
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
        Schema::dropIfExists('member_latest_txn_infos');
    }
}
