<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberInvestmentListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_investment_lists', function (Blueprint $table) {
            $table->id();
            $table->string('depositId');
            $table->string('userId');
            $table->float('amount');
            $table->string('package');
            $table->float('income_percent');
            $table->integer('invest_status')->default(0);
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
        Schema::dropIfExists('member_investment_lists');
    }
}
