<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Topic;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $hint
 * @property string $question
 * @property array $options
 * @property array $answers
 * @property string $explanation
 * @property int $mark
 * @property int $nmark
 * @property int $qtype
 * @property int $created_by
 * @property int $exam_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Collection<Topic> $topics
 * @property Exam $exam
 */

class Question extends Model
{
    use SoftDeletes, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'qtype', 'question', 'options', 'answers', 'hint', 'mark', 'nmark', 'explanation', 'created_by'
    ];

    protected $casts = [
        'answers' => 'array',
        'options' => 'array'
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESORS Variables
    |--------------------------------------------------------------------------
    */
    public static $qtypes = [
        'Objective' => 0,
        'TrueFalse'   => 1,
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getQtypeAttribute($value)
    {
        $key = array_search($value, self::$qtypes);

        if ($key) {
            return ucfirst($key);
        }
    }

    public function setQtypeAttribute($value)
    {
        $key = array_search($value, self::$qtypes);

        if ($key) {
            $this->attributes['qtype'] = $value;
        } else {
            $this->attributes['qtype'] = self::$qtypes[$value];
        }
    }

    public function topics()
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function setAnswerAttribute($value)
    {
        $this->attributes['answers'] = json_encode($value);
    }
}
