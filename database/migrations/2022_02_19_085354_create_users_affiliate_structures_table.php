<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersAffiliateStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_affiliate_structures', function (Blueprint $table) {
            $table->increments('id')->nullable(false);
            $table->string('userId');
            $table->string('leftUser');
            $table->float('leftside_funds');
            $table->string('rightUser');
            $table->float('rightside_funds');
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
        Schema::dropIfExists('users_affiliate_structures');
    }
}
