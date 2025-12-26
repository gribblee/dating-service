<?php

declare(strict_types=1);

namespace App\Router {

    use App\Enums\HttpStatus;
    use App\Exception\HttpNotFoundException;
    use App\FastLog;
    use App\ValueObject\ParamsObject;
    use App\ValueObject\ResponseObject;
    use Exception;

    function ExecuteRouter(): ResponseObject
    {
        /** @var array<string, array<string, mixed>> $routers */
        $routers = require __DIR__ . DIRECTORY_SEPARATOR . '/Config/routers.php';
        $path = (string)parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $method = ($_SERVER['REQUEST_METHOD'] ?? '');
        $input = file_get_contents('php://input');
        $input = false === $input ? '' : $input;
        $params = new ParamsObject(
            query: $_GET,
            body: $input,
        );
        try {
            if (!isset($routers[$method])) {
                if (!isset($routers[$method][$path])) {
                    throw new HttpNotFoundException();
                }
            }
            $controller = $routers[$method][$path];
            return $controller->__invoke($params);
        } catch (HttpNotFoundException $e) {
            FastLog::error($e->getMessage(), [
                'status' => '404',
                'path' => $path,
                'params' => $params
            ]);
            return new ResponseObject(
                result: ['msg' => '404 Not Found'],
                status: HttpStatus::NOT_FOUND
            );
        } catch (Exception $e) {
            FastLog::error($e->getMessage(), [
                'status' => '500',
                'path' => $path,
                'params' => $params
            ]);
            return new ResponseObject(
                result: ['msg' => 'Unexpected Error'],
                status: HttpStatus::INTERNAL_SERVER_ERROR
            );
        }
    }
}
