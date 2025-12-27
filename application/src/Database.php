<?php

declare(strict_types=1);

namespace App;

use Exception;
use PgSql\Connection;
use PgSql\Result;

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

    public function query(string $query, array $params = []): false|Result
    {
        return pg_query_params($this->connection, $query, $params);
    }

    public function fetch(Result $result): false|object
    {
        return pg_fetch_object($result);
    }
}
