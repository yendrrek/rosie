<?php

namespace Rosie\Utils;

use JetBrains\PhpStorm\Pure;

class NameOfClass
{
    public static function getClassName($instance): string
    {
        $pageName = PageName::getPageName();
        $artworkPageNames = ['All Works', 'Geometry', 'Stained Glass', 'Ceramic Tiles', 'Paintings'];

        if (in_array($pageName, $artworkPageNames)) {
            return self::getArtworkClassName($instance);
        }
        return self::getProfaneClassName($pageName, $instance);
    }

    #[Pure] private static function getArtworkClassName($instance): string
    {
        return self::getLayer($instance, 'Artwork', 'ArtworkDepCont');
    }

    private static function getProfaneClassName($pageName, $instance): string
    {
        return self::getLayer($instance, self::removeSpace($pageName), self::removeSpace($pageName) . 'DepCont');
    }

    private static function getLayer($instance, $controller, $service): string
    {
        return $instance == 'controller' ? $controller : $service;
    }

    private static function removeSpace($className): string
    {
        return str_replace(' ', '', $className);
    }
}
