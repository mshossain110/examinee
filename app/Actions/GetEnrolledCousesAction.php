<?php
namespace App\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetEnrolledCousesAction
{
    public static function getCourses(User $student, bool $pagination = false):LengthAwarePaginator | Collection
    {
        if ($pagination) {
            return $student->enrolledCourses()->paginate();
        }

        return $student->enrolledCourses;
    }
}