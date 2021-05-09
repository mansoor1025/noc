<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('payment_id');
            $table->foreignId('payment_period')->constrained('periods');
            $table->string('date');
            $table->bigInteger('shipping_charges');
            $table->bigInteger('cod_amount');
            $table->bigInteger('amount');
            $table->bigInteger('total_amount');
            $table->bigInteger('deduction');
            $table->bigInteger('arrears');
            $table->bigInteger('flyer_charges');
            $table->boolean('post');
            //
            $table->bigInteger('total_cod_amount');
            $table->bigInteger('collectable_cod');
            //
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
        Schema::dropIfExists('invoices');
    }
}
