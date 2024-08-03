<?php

declare(strict_types=1);

namespace Tests\Fixtures;

class HasNoProfanity
{
    public function __construct(
        public string $name,
        public string $description,
    ) {}
}
