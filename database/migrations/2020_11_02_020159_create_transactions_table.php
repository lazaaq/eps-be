<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('id',20)->primary();
			$table->integer('collager_id')->unsigned();
            $table->integer('unique_payment');
            $table->integer('amount_paid')->nullable();
            $table->string('payment_method',50);
            $table->string('status',50);
            $table->string('proof_of_payment')->nullable();
            $table->string('start_date',50)->nullable();
            $table->string('expired_date',50)->nullable();
            $table->timestamps();

			$table->foreign('collager_id')->references('id')->on('collagers');
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
