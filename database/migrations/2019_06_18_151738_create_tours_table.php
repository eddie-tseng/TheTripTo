<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('photo',50)->nullable();
            $table->text('introduction');
            $table->string('sub_title', 100);
            $table->integer('price')->default(0);
            $table->integer('sold')->default(0);
            $table->integer('inventory')->default(0);
            $table->integer('rating')->default(0);
            $table->string('country', 100);
            $table->string('city', 100);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('status',1);
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('tours');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
