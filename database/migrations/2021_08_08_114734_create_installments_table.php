<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("creator_id");   //users.id
            $table->unsignedBigInteger("borrower_id");
            $table->unsignedBigInteger("account_id");
            $table->unsignedBigInteger("loan_id");

            $table->date("date");
            $table->double("previous_debt");
            $table->double("amount");
            $table->double("current_debt");
            $table->string("payment_method")->nullable();
            $table->text("files")->nullable();


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
        Schema::dropIfExists('installments');
    }
}
