<?php
namespace App\Actions;

use App\Http\Resources\CourseResource;
use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CourseWithSections
{
    public static function getCourses(Course $course)
    {
        
        return Cache::remember('courseforStudent-' . $course->id, now()->addDays(1), function()use ($course) {
            $course->load(['sections.lessons', 'sections.exams']);

                $course->sections->map( function(Section $section) {

                    $resources = new Collection([]);
                    $section->lessons->each(function($lesson) use($resources) {
                        $resources->push($lesson);
                    });

                    
                    $section->exams->each(function($exam) use($resources) {
                        $resources->push($exam);
                    });

                    $resources->sortBy('pivot.order');

                    $section->resources = $resources;

                    unset($section->lessons);
                    unset($section->exams);

                    return $section;
                });

                return new CourseResource($course);
        });
    }
}