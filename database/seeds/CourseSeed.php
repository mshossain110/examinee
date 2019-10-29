<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Lesson;
use App\Test;

class CourseSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Course::class, 15)->create()->each(function ($course) {
            $course->teachers()->sync(rand(1, 10));
            $course->students()->sync(rand(1, 2));
            $course->lessons()->saveMany(factory(Lesson::class, 10)->create(['course_id' => $course->id]));
        });
    }
}
