<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
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
            $table->unsignedBigInteger("creator_id");   //users.id
            $table->unsignedBigInteger("borrower_id");
            $table->unsignedBigInteger("account_id");

            $table->date("disbursement_date");  //disbursement = বিতরণ
            $table->date("closing_date")->nullable();

            $table->double("loan_amount");
            $table->double("installment_amount")->default(0);
            $table->unsignedBigInteger("installment_quantity")->default(1);

            $table->double("collection_amount")->default(0);    //calculated when installment updates
            $table->double("due_amount")->default(0);           //calculated when installment updates
            $table->date("last_collection_date")->nullable();   //each time new installment is added it gets updated

            $table->string("status");   //active, inactive, closed, defaulted

            $table->timestamps();
            $table->softDeletes();
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
