<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Lesson;
use App\Question;
use App\Exam;
use App\LessonsSection;


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
            $course->subjects()->attach(rand(1, 5));
            $course->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
            factory(LessonsSection::class, 5)->create()->each(function($section) use($course) {
                $course->lessons()->saveMany(factory(Lesson::class, 10)->create(['lessons_section_id' => $section->id, 'course_id' => $course->id ]));
            });

            factory(Exam::class, rand(1, 8))->create()->each(function ($exam) {
            
                $exam->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
                
    
                factory(Question::class, 20)->create(['exam_id' => $exam->id]);
                
            });
            
        });
    }
}
