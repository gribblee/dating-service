<?php

declare(strict_types=1);

namespace App\Controllers;

use App\FastLog;
use App\Handlers\TestHandler;
use App\ValueObject\ParamsObject;
use App\ValueObject\ResponseObject;

final class TestController implements ControllerInterface
{
    private TestHandler $handler;

    public function __construct(
        private FastLog $fastLog
    ) {
        $this->handler = new TestHandler();
    }

    public function execute(
        ParamsObject $params
    ): ResponseObject {
        $this->fastLog->info(json_encode($this->handler->handle()));
        return new ResponseObject(
            result: [
                'id' => $params->getBody()?->id ?? null,
                'sort' => $params->getQuery()['sort'],
            ]
        );
    }
}
