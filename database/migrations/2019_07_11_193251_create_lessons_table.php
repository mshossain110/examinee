<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('course_id')->unsigned();
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('thumbnail')->nullable();
                $table->tinyInteger('type')->default(1);
                $table->json('object')->nullable();
                $table->text('short_text')->nullable();
                $table->text('full_text')->nullable();
                $table->integer('position')->nullable()->unsigned();
                $table->tinyInteger('free_lesson')->nullable()->default(0);
                $table->tinyInteger('status')->nullable()->default(0);
                
                $table->timestamps();
                $table->softDeletes();

                $table->integer('created_by')->unsigned();
                $table->integer('updated_by')->unsigned();
                
                $table->index(['deleted_at']);
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
