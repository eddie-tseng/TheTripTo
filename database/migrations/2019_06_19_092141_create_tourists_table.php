<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTouristsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourists', function (Blueprint $table) {
            //Primary key: first_name, last_name, id
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('gender',1);
            $table->date('birth_date');
            $table->string('mail',150);
            $table->string('phone',20);
            $table->string('country',20);
            //Foreign Key: id
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->primary(['first_name', 'last_name', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourists');
    }
}
