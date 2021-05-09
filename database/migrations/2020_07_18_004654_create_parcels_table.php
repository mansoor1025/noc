<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_status_id');
            $table->foreignId('customer_id');
            $table->foreignId('shipping_partner_id');
            $table->foreignId('source_id');
            $table->foreignId('province_id');
            $table->string('weight');
            $table->string('tracking_id');
            $table->string('reference_no');
            $table->string('user_name');
            $table->string('email');
            $table->string('mobile_no');
            $table->string('user_address');
            $table->string('city');
            $table->bigInteger('cod_amount');
            $table->bigInteger('shipping_amount');
            $table->bigInteger('total_amount');
            $table->string('rider_print');
            $table->boolean('validate');
            $table->boolean('bit');
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
        Schema::dropIfExists('parcels');
    }
}
