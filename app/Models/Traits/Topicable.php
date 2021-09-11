<?php

namespace App\Models\Traits;

use App\Models\Topic;

trait Topicable
{
    /**
     * Return polymorphic relationship with json casted meta.
     */
    public function topics()
    {
        return $this->morphToMany(Topic::class, 'topicable');
    }
}
