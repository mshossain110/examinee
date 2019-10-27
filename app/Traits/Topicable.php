<?php

namespace App\Traits;

use App\Topic;

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
