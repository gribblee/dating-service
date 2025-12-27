<?php

declare(strict_types=1);

use App\Controllers\TestController;

return [
    'POST' => [
        '/swipe' => TestController::class,
    ]
];
