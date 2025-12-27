<?php

declare(strict_types=1);

namespace App\Handlers;

use App\Database;
use PgSql\Result;

final class TestHandler
{
    private Database $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function handle(): array
    {
        $result = $this->db->query('SELECT * FROM test_table');
        $d = [];
        while($row = $this->db->fetch($result)) {
            $d[$row->name] = $row->id;
        }
        return $d;
    }
}
