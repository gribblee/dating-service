<?php

declare(strict_types=1);

namespace App;

function Bootstrap(): void
{
    $dirLogs = __DIR__ . '/../var/logs';

    if (!is_dir($dirLogs)) {
        mkdir($dirLogs, 0755, true);
    }

    $router = new Router(
        logger: new FastLog($dirLogs . '/' . ($_ENV['APP_ENV'] ?? 'dev') . '.log')
    );

    $response = $router->ExecuteRouter();

    ob_start();
    ob_clean();

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Content-Type: application/json');
    header('HTTP/1.1 ' . $response->getStatus()->value . ' OK');

    echo json_encode($response->getResult());
    ob_end_flush();
}
