<?php

namespace Rosie\Controllers;

use Rosie\DependenciesContainers\BasketDepCont;

class Basket
{
    public function __construct(private BasketDepCont $basketDepCont)
    {
    }

    public function runPage(): void
    {
        include 'views/basket-content.php';
    }
}
