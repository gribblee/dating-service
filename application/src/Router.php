<?php

declare(strict_types=1);

namespace App;

use App\Controllers\ControllerInterface;
use App\Enums\HttpStatus;
use App\Exception\HttpNotFoundException;
use App\ValueObject\ParamsObject;
use App\ValueObject\ResponseObject;
use Exception;

class Router
{
    public function __construct(
        private FastLog $logger
    ) {
    }

    public function ExecuteRouter(
    ): ResponseObject {
        /** @var array<string, array<string, ControllerInterface>> $routers */
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
            return new $routers[$method][$path]($this->logger)->execute($params);
        } catch (HttpNotFoundException $e) {
            $this->logger->error($e->getMessage(), [
                'status' => '404',
                'path' => $path,
                'params' => $params
            ]);
            return new ResponseObject(
                result: ['msg' => '404 Not Found'],
                status: HttpStatus::NOT_FOUND
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage(), [
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
