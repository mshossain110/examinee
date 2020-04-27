<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Lesson;
use App\Question;
use App\Exam;
use App\Session;
use App\Sessionable;

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
            $course->teachers()->sync(rand(1, 3));
            $course->teachers()->sync(rand(1, 10));

            $course->students()->sync(rand(1, 3));
            $course->students()->sync(rand(1, 10));

            $course->subjects()->attach(rand(1, 5));
            $course->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
            $sessions = factory(Session::class, 5)->create(['course_id'=> $course->id]);
          
            factory(Lesson::class, 15)->create()->each(function($lesson) use($sessions, $course) {
                $course->lessons()->save($lesson, [
                    'session_id' => $sessions->random()->id,
                    'sessionable_type' => Lesson::class,
                    'order' => rand(1, 15)
                ]);
            });

            factory(Exam::class, rand(5, 15))->create()->each(function ($exam) use($sessions, $course) {
            
                $exam->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
    
                factory(Question::class, 20)->create(['exam_id' => $exam->id]);
                
                $course->exams()->save($exam, [
                    'session_id' => $sessions->random()->id,
                    'sessionable_type' => Exam::class,
                    'order' => rand(15, 30)
                ]);

            });
            
        });
    }
}
