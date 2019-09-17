<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailableDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('available_dates', function (Blueprint $table) {
            $table->date('available_date');
            //$table->integer('sub_title_daily_count_max')->default(0);
            //Foreign Key: tour_id
            $table->unsignedInteger('tour_id');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->primary(['tour_id', 'available_date']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('available_dates');
    }
}
