<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['answers', 'obtain'];

    protected $casts = [
        'answers' => 'array',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function examinee()
    {
        return $this->belongsTo(User::class, 'examinee');
    }

    public static function calculateMark($answer)
    {
        $count = 0;
        if (!empty($answer)) {
            foreach ($answer as $resultKey => $resultValue) {
                $question = Question::where('id', $resultKey)->first();
                if (!empty($question)) {
                    foreach ($question->answer as $key => $value) {
                        if ($resultValue == $value) {
                            $count = $count + $question->mark;
                        }
                    }
                }
            }
        }
        return $count;
    }
}
