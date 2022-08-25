<?php

namespace Rosie\DependenciesContainers;

use PDOStatement;
use Rosie\Services\ContentDatabaseQuery\ContentDatabaseQuery;
use Rosie\Utils\Token;

class ShopDepCont
{
    public function __construct(
        private ContentDatabaseQuery $contentDatabaseQuery,
        public Token $token
    ) {
    }

    public function runDependencies(): PDOStatement
    {
        $query = 'CALL getCards()';
        return $this->contentDatabaseQuery->getContentFromDatabase($query);
    }
}
