<?php

namespace Rosie\Controllers;

use Rosie\Utils\PageName;
use Rosie\Utils\PageTitle;

class Footer
{
    public static function getFooter(): void
    {
        $pageName = PageName::getPageName();
        $pageTitle = PageTitle::getPageTitle();
        include $pageName !== 'Capture Transaction Error' ? 'views/footer.php' : null;
    }
}
