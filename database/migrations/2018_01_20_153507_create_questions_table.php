<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger( 'qtype' )->default( 0 )->comment( '0: Objective; 1: True/False;');
            $table->string("question");
            $table->string("options")->nullable();
            $table->string("answer");
            $table->string("hint")->nullable();
            $table->integer("mark")->default(1);
            $table->integer("nmark")->default(0);
            $table->string("explanation")->nullable();
            $table->integer("defficulty")->default(1);
            $table->integer("parent")->nullable();
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
        Schema::dropIfExists('questions');
    }
}
