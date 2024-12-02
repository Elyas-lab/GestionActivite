<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class OracleService
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function setOracleSessionParams(): void
    {
        $this->connection->executeQuery("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $this->connection->executeQuery("ALTER SESSION SET NLS_TIMESTAMP_FORMAT = 'YYYY-MM-DD HH24:MI:SS'");
        $this->connection->executeQuery("ALTER SESSION SET NLS_TIMESTAMP_TZ_FORMAT = 'YYYY-MM-DD HH24:MI:SS TZH:TZM'");
    }
}
