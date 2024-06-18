<?php
namespace App\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GetInstratorCousesAction
{
    public static function getCourses(User $instraotor, bool $pagination = false):LengthAwarePaginator | Collection
    {
        if ($pagination) {
            return $instraotor->instructCourses()->paginate();
        }

        return $instraotor->instructCourses;
    }
}