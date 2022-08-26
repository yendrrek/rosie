<?php

namespace Rosie\Utils;

class PageTitle
{
    public static function getPageTitle(): string
    {
        $pageName = PageName::getPageName();
        return "$pageName | Rosie Piontek - Traditional Artist";
    }
}
