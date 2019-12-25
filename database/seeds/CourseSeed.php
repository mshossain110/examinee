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
            $course->teachers()->sync(rand(1, 10));
            $course->students()->sync(rand(1, 2));
            $course->subjects()->attach(rand(1, 5));
            $course->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
            $sessions = factory(Session::class, 5)->create();
            factory(Lesson::class, 10)->create(['course_id' => $course->id ])->each(function($lesson) use($sessions, $course) {
                $lesson->sessionable()->create([
                    'session_id' => $sessions->random()->id,
                    'course_id' => $course->id,
                    'order' => $lesson->id
                ]);
            });

            factory(Exam::class, rand(1, 8))->create()->each(function ($exam)  use($sessions, $course) {
            
                $exam->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
                $exam->courses()->attach([$course->id]);
    
                factory(Question::class, 20)->create(['exam_id' => $exam->id]);
                
                $exam->sessionable()->create([
                    'session_id' => $sessions->random()->id,
                    'course_id' => $course->id,
                    'order' => ($exam->id + 10)
                ]);
                
            });
            
        });
    }
}
