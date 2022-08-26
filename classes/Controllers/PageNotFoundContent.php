<?php

namespace Rosie\Controllers;

use Rosie\Utils\PageName;

class PageNotFoundContent
{
    public static function showPageNotFoundInfo(): bool
    {
        $pageName = PageName::getPageName();

        if (empty($pageName)) {
            echo '<head><title>Page not found</title></head>';
            echo '<p>Page requested does not exist</p><br><br><a href="all-works.php">Go to Homepage</a>';
            return true;
        }
        return false;
    }
}
