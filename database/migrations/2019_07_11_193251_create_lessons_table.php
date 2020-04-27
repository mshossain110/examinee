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
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('thumbnail')->nullable();
                $table->unsignedTinyInteger('type')->default(1)->comment("1=>text, 2=> video, 3=>audio, 4=> pdf ");
                $table->json('object')->nullable();
                $table->text('short_text')->nullable();
                $table->text('full_text')->nullable();
                $table->unsignedTinyInteger('position')->default(1);
                $table->unsignedTinyInteger('status')->default(1)->comment("1=>free, 2=>subscriber, 3=>paid");
                
                $table->timestamps();
                $table->softDeletes();

                $table->bigInteger('created_by')->unsigned();
                $table->bigInteger('updated_by')->unsigned();
                
                $table->index(['deleted_at']);
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
