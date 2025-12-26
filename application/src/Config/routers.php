<?php

declare(strict_types=1);

use App\ValueObject\ParamsObject;
use App\ValueObject\ResponseObject;

return [
    'POST' => [
        '/swipe' => fn (ParamsObject $params): ResponseObject => \App\Controllers\TestController($params)
    ]
];
