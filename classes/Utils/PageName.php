<?php

namespace Rosie\Utils;

class PageName
{
    private static array $namesOfPagesInUrl = [
        'all-works',
        'geometry',
        'stained-glass',
        'ceramic-tiles',
        'paintings',
        'about',
        'contact',
        'shop',
        'basket',
        'purchase-completed',
        'capture-transaction-error'
    ];

    public static function getPageName(): string
    {
        $currentPageUrl = $_SERVER['REQUEST_URI'];

        foreach (self::$namesOfPagesInUrl as $nameOfPage) {
            if (str_contains($currentPageUrl, $nameOfPage)) {
                return self::formatPageName($nameOfPage);
            }
        }
        return false;
    }

    public static function fitSlideshowSectionNameOnSmallScreen(): array|string
    {
        $currentPageUrl = $_SERVER['REQUEST_URI'];

        foreach (self::$namesOfPagesInUrl as $nameOfPage) {
            if (str_contains($currentPageUrl, $nameOfPage)) {
                return explode(' ', self::formatPageName($nameOfPage));
            }
        }
        return [];
    }

    private static function formatPageName($nameOfPage): string
    {
        return ucwords(str_replace('-', ' ', $nameOfPage));
    }
}
