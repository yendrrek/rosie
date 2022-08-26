<?php

namespace Rosie\Controllers;

use Rosie\Utils\PageName;
use Rosie\Utils\PageTitle;

class Head
{
    public static function getHead(): void
    {
        $pageName = PageName::getPageName();
        $pageTitle = PageTitle::getPageTitle();
        include $pageName !== 'Capture Transaction Error' ? 'views/head.php' : 'views/capture-transaction-error.html';
    }
}
