<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightRangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('city_id');
            $table->double('range_from');
            $table->double('range_to');
            $table->bigInteger('national_amount');
            $table->bigInteger('local_amount');
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
        Schema::dropIfExists('weight_ranges');
    }
}
