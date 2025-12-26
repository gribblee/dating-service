<?php

declare(strict_types=1);

namespace App\ValueObject;

final readonly class ParamsObject
{
    public function __construct(
        public array $query,
        public string $body
    ) {
    }
}
