<?php

declare(strict_types=1);

namespace App;

use Exception;
use PgSql\Connection;

readonly class Database
{
    private Connection $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (empty($_ENV['DATABASE_DSN'] ?? '')) {
            throw new Exception('DATABASE_DSN not defined');
        }
        $connection = pg_connect($_ENV['DATABASE_DSN'] ?? '');
        if (false === $connection) {
            throw new Exception('Connection failed');
        }
        $this->connection = $connection;
    }
}
