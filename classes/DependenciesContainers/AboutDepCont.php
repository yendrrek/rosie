<?php

namespace Rosie\DependenciesContainers;

use PDOStatement;
use Rosie\Services\ContentDatabaseQuery\ContentDatabaseQuery;

class AboutDepCont
{
    public function __construct(private ContentDatabaseQuery $contentDatabaseQuery)
    {
    }

    public function runDependencies(): PDOStatement
    {
        $query = 'SELECT * FROM aboutContent ORDER BY id';
        return $this->contentDatabaseQuery->getContentFromDatabase($query);
    }
}
