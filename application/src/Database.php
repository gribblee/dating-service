<?php

declare(strict_types=1);

namespace App\Database {
    use PgSql\Connection;

    /**
     * @throws \Exception
     */
    function GetConnection(): Connection
    {
        if (empty($_ENV['DATABASE_DSN'] ?? '')) {
            throw new \Exception('DATABASE_DSN not defined');
        }
        $connection = pg_connect($_ENV['DATABASE_DSN'] ?? '');
        if (false === $connection) {
            throw new \Exception('Connection failed');
        }
        return $connection;
    }
}
