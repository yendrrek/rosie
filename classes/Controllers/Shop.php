<?php

namespace Rosie\Controllers;

use PDOStatement;
use Rosie\DependenciesContainers\ShopDepCont;

class Shop
{
    public PDOStatement $resultCards;

    public function __construct(private ShopDepCont $shopDepCont)
    {
    }

    public function runPage(): void
    {
        include 'views/shop-content.php';
    }
}
