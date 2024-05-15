<?php

namespace App\Models;

use App\Models\Exam;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use SoftDeletes, HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
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

    public function setTypeAttribute($value)
    {
        $value = strtolower($value);
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
