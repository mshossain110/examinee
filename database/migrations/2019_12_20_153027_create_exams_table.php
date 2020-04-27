<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('examiner')->unsigned();
            $table->string('title');
            $table->text("description")->nullable();
            $table->unsignedTinyInteger('status')->default(1)->index()->comment("1=>free, 2=>course, 3=>course & paid, 4=>paid");
            $table->integer("price")->nullable();
            $table->unsignedTinyInteger('duration')->default(0);
            $table->unsignedTinyInteger('pass_mark')->default(0);
            $table->unsignedTinyInteger('number_of_questions')->default(0);
            $table->boolean('random_questions')->default(true);
            $table->boolean('certification')->default(false);
            $table->unsignedTinyInteger("difficulty")->default(1);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->softDeletes()->index();


            $table->foreign('examiner')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
