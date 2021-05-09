<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        DB::insert("INSERT INTO `periods` (`id`, `name`, `description`) VALUES
            (1, '1st Period', '1 to 7'),
            (2, '2nd Period', '8 to 14'),
            (3, '3rd Period', '15 to 21'),
            (4, '4th Period', '22 to remaining');
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periods');
    }
}
