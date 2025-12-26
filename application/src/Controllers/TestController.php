<?php

declare(strict_types=1);

namespace App\Controllers {
    use App\ValueObject\ParamsObject;
    use App\ValueObject\ResponseObject;

    function TestController(
        ParamsObject $params
    ): ResponseObject {
        $body = simdjson_decode($params->body);
        return new ResponseObject(
            result: [
                'id' => $body->id,
                'sort' => $params->query['sort'],
            ]
        );
    }
}
