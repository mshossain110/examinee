<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjectables', function( Blueprint $table ){
            $table->bigInteger('subject_id')->unsigned();
            $table->morphs('subjectables');

            
            $table->foreign('subject_id')
                    ->references('id')->on('topics')
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
        Schema::dropIfExists('subjectables');
    }
}
