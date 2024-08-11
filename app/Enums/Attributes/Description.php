<?php

namespace App\Domain\Common\Enums\Attributes;

use Attribute;

#[Attribute]
class Description
{
    public function __construct(
        public string $description,
    ) {
        //
    }
}
