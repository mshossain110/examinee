<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Question;
use App\Models\ExamSession;
use App\Models\ExamSessionable;
use Illuminate\Database\Seeder;

class CourseSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = (int) $this->command->ask('How Course seed do you need ?', 10);
        Course::factory()->count($count)->create()->each(function ($course) {
            $course->teachers()->sync(rand(1, 3));
            $course->teachers()->sync(rand(1, 10));

            $course->students()->sync(rand(1, 3));
            $course->students()->sync(rand(1, 10));

            $course->subjects()->attach(rand(1, 100));
            $course->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
            $sessions = Section::factory()->count(5)->create(['course_id' => $course->id]);

            Lesson::factory()->count(15)->create()->each(function ($lesson) use ($sessions, $course) {
                $course->lessons()->save($lesson, [
                    'section_id' => $sessions->random()->id,
                    'sectionable_type' => Lesson::class,
                    'order' => rand(1, 15)
                ]);
            });

            Exam::factory()->count(rand(3, 8))->create()->each(function ($exam) use ($sessions, $course) {

                $exam->topics()->attach([rand(1, 5), rand(1, 10), rand(1, 10), rand(1, 10)]);
                $exam->subjects()->attach(rand(1, 100));
                Question::factory()->count(20)->create(['exam_id' => $exam->id]);

                $course->exams()->save($exam, [
                    'section_id' => $sessions->random()->id,
                    'sectionable_type' => Exam::class,
                    'order' => rand(15, 30)
                ]);
            });
        });
    }
}
