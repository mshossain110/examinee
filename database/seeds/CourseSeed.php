<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Lesson;
use App\LessonsSection;
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
            factory(LessonsSection::class, 5)->create()->each(function($section) use($course) {
                $course->lessons()->saveMany(factory(Lesson::class, 10)->create(['lessons_section_id' => $section->id, 'course_id' => $course->id ]));
            });
            
        });
    }
}
