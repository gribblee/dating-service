<?php

declare(strict_types=1);

namespace App\ValueObject;

final readonly class ParamsObject
{
    public function __construct(
        private array $query,
        private string $body
    ) {
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function getRawBody(): string
    {
        return $this->body;
    }

    public function getBody(): \stdClass
    {
        return simdjson_decode($this->body);
    }
}
