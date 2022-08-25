<?php

namespace Rosie\DependenciesContainers;

use Rosie\Services\ContentDatabaseQuery\ContentDatabaseQuery;

class ArtworkDepCont
{
    public function __construct(public ContentDatabaseQuery $contentDatabaseQuery)
    {
    }

    public function runDependencies(): void
    {
        // All necessary logic is run in the controller 'Artwork',
        // where content is inserted
    }
}
