<?php

namespace Rosie\Controllers;

use Rosie\Services\Basket\BasketIcon;
use Rosie\Utils\PageName;

class Breadcrumbs extends BasketIcon
{
    public static function getBreadcrumbs(): void
    {
        $pageName = PageName::getPageName();

        if ($pageName !== 'Purchase Completed' && $pageName !== 'Capture Transaction Error') {
            include './views/breadcrumbs.php';
        }
    }
}
