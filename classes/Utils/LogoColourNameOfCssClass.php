<?php

namespace Rosie\Utils;

class LogoColourNameOfCssClass
{
    public static function setLogoColourCssClassName(): string
    {
        $pageName = PageName::getPageName();

        return match (true) {
            $pageName == 'All Works' || $pageName == 'Paintings' => 'logo_orange',
            $pageName == 'Geometry' => 'logo_green',
            $pageName == 'Stained Glass' => 'logo_yellow',
            $pageName == 'Ceramic Tiles' => 'logo_brown',
            default => false,
        };
    }
}
