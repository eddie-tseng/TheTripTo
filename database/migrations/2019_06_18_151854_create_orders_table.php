<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status', 1);
            $table->date('travel_date');
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->string('payment', 10);
            $table->timestamps();
            //Foreign Key: tour_id, id
            $table->unsignedInteger('tour_id');
            $table->foreign('tour_id')
                  ->references('id')
                  ->on('tours')
                  ->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('orders');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
