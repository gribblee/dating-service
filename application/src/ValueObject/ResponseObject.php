<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enums\HttpStatus;

final readonly class ResponseObject
{
    public function __construct(
        private mixed $result = null,
        private HttpStatus $status = HttpStatus::OK
    ) {
    }

    public function getResult(): mixed
    {
        return $this->result;
    }

    public function getStatus(): HttpStatus
    {
        return $this->status;
    }
}
