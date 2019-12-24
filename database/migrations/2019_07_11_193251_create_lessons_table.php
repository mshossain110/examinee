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
                $table->bigInteger('course_id')->unsigned();
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('thumbnail')->nullable();
                $table->unsignedTinyInteger('type')->default(1)->comment("1=>text, 2=> video, 3=>audio, 4=> pdf ");
                $table->json('object')->nullable();
                $table->text('short_text')->nullable();
                $table->text('full_text')->nullable();
                $table->unsignedTinyInteger('position')->default(1);
                $table->unsignedTinyInteger('status')->default(0)->comment("1=>public, 2=>hidden, 3=>subscriber, 4=>archived ");
                
                $table->timestamps();
                $table->softDeletes();

                $table->bigInteger('lessons_section_id')->index()->unsigned();

                $table->bigInteger('created_by')->unsigned();
                $table->bigInteger('updated_by')->unsigned();
                
                $table->index(['deleted_at']);
                $table->foreign('lessons_section_id')->references('id')->on('lessons_sections');
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
