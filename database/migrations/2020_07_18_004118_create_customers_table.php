<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('full_name');
            $table->string('company_name');
            $table->string('last_parcel_no');
            $table->string('user_name');
            $table->string('email');
            $table->string('mobile_no_1');
            $table->string('mobile_no_2');
            $table->string('cnic');
            $table->string('city');
            $table->string('shipper_address');
            $table->string('bank');
            $table->string('bank_branch');
            $table->string('account_title');
            $table->date('birth_date');
            $table->date('anniversary_date')->nullable();
            $table->boolean('agree_terms');
            $table->boolean('status');
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
        Schema::dropIfExists('customers');
    }
}
