<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamSubject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_subject', function( Blueprint $table ){
            $table->unsignedInteger('eid')->references('id')->on('exams')->onDelete('cascade');
            $table->unsignedInteger('sid')->references('id')->on('subjects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_subject');
    }
}
