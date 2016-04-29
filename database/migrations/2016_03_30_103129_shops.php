<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Shops extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->integer('city_id');
            $table->string('title');
            $table->string('description');
            $table->string('time');
            $table->string('street');
            $table->string('url')->nullable();

            $table->string('lat');
            $table->string('lon');

            $table->string('phone');
            $table->date('date_start');
            $table->date('date_stop');

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
        Schema::dropIfExists('shops');
    }
}
