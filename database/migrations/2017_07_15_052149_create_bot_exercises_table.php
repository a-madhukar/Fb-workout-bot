<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBotExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bot_exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); 
            $table->integer('lower_bound'); 
            $table->integer('upper_bound'); 
            $table->string('unit'); 
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
        Schema::dropIfExists('bot_exercises');
    }
}
