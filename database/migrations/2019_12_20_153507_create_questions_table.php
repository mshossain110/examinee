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
            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned();
            $table->tinyInteger( 'qtype' )->default( 0 )->comment( '0: Objective; 1: True/False;');
            $table->string("question");
            $table->json("options");
            $table->json("answers");
            $table->string("hint")->nullable();
            $table->integer("mark")->default(1);
            $table->integer("nmark")->default(0);
            $table->string("explanation")->nullable();
            $table->bigInteger('exam_id')->unsigned()->index();

            $table->timestamps();
            $table->softDeletes()->index();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('cascade');
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
