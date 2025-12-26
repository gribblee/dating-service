<?php

declare(strict_types=1);

namespace App {

    use function App\Router\ExecuteRouter;

    function Bootstrap(): void
    {
        $dirLogs = __DIR__ . '/../var/logs';

        if (!is_dir($dirLogs)) {
            mkdir($dirLogs, 0755, true);
        }
        FastLog::init($dirLogs . '/' . ($_ENV['APP_ENV'] ?? 'dev') . '.log');
        $response = ExecuteRouter();

        ob_start();
        ob_clean();

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Content-Type: application/json');
        header('HTTP/1.1 ' . $response->getStatus()->value . ' OK');

        echo json_encode($response->getResult());
        ob_end_flush();
    }

    register_shutdown_function([FastLog::class, 'flush']);
}
