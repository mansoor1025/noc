<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadSheetParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('load_sheet_parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('load_sheet_id');
            $table->foreignId('parcel_id');
            $table->boolean('scan');    //0 or 1
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
        Schema::dropIfExists('load_sheet_parcels');
    }
}
