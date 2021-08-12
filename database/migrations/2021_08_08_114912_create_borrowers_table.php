<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("nid")->nullable();
            $table->string("fathers_name")->nullable();
            $table->string("mothers_name")->nullable();
            $table->string("spouse_name")->nullable();
            $table->string("gender")->nullable();
            $table->date("date_of_birth")->nullable();

            //address
            $table->string("present_division")->nullable();
            $table->string("present_district")->nullable();
            $table->string("present_upazila")->nullable();
            $table->string("present_thana")->nullable();
            $table->string("present_village")->nullable();

            $table->string("permanent_division")->nullable();
            $table->string("permanent_district")->nullable();
            $table->string("permanent_upazila")->nullable();
            $table->string("permanent_thana")->nullable();
            $table->string("permanent_village")->nullable();

            //contact information
            $table->string("email")->nullable();
            $table->string("phone")->nullable();

            $table->string("photo")->nullable();
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
        Schema::dropIfExists('borrowers');
    }
}
