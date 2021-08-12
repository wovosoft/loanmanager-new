<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("created_by");   //user id
            $table->unsignedBigInteger("borrower_id");
            $table->string("account_no");
            $table->string("account_name");
            $table->string("type")->nullable();

            $table->boolean("is_active")->default(true);
            $table->date("opening_date")->nullable();
            $table->date("closing_date")->nullable();

            $table->text("description")->nullable();

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
        Schema::dropIfExists('accounts');
    }
}
