<?php

namespace Rosie\Services\ContentDatabaseQuery;

use PDO;
use PDOStatement;

class ContentDatabaseQuery
{
    public function __construct(private PDO $dbConn)
    {
    }

    public function getContentFromDatabase($query): PDOStatement
    {
        $dbConn = $this->dbConn;
        return $dbConn->query($query);
    }
}
