<?php

namespace Rosie\Controllers;

use Rosie\DependenciesContainers\AboutDepCont;

class About
{
    public function __construct(private AboutDepCont $aboutDepCont)
    {
    }

    public function runPage(): void
    {
        include 'views/about-content.php';
    }
}
