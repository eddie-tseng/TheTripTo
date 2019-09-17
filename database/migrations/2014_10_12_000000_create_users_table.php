<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //increments()會自動設為主鍵
            $table->increments('id');
            $table->string('account',150)->unique();
            $table->string('fb_account',150)->nullable();
            $table->string('password',100);
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('photo',50)->nullable();
            $table->string('gender',1)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('mail',150)->unique();
            $table->string('phone',20)->unique();
            $table->string('country',20)->nullable();
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
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
