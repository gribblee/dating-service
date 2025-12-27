<?php

declare(strict_types=1);

namespace App\Controllers;

use App\ValueObject\ParamsObject;
use App\ValueObject\ResponseObject;

interface ControllerInterface
{
    public function execute(ParamsObject $params): ResponseObject;
}
