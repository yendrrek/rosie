<?php

namespace Rosie\Controllers;

use PDO;
use PDOStatement;
use Rosie\Services\Basket\BasketIcon;
use Rosie\Utils\PageName;

class NavigationItemsForDifferentScreenSizes extends BasketIcon
{
    public PDOStatement $resultMainNav;
    public PDOStatement $resultSubNav;
    public PDOStatement $resultSmallMainNav;
    public PDOStatement $resultSmallSubNav;
    public PDOStatement $resultBasket;
    public PDOStatement $resultBasketSmallNav;

    public function __construct(private PDO $dbConn)
    {
    }

    public function getNavigationItemsForDifferentScreenSizes(): void
    {
        $pagesWithMainNav = [
            'All Works',
            'Geometry',
            'Stained Glass',
            'Ceramic Tiles',
            'Paintings',
            'About',
            'Contact',
            'Shop'
        ];

        $pageName = PageName::getPageName();

        if (in_array($pageName, $pagesWithMainNav)) {
            $this->resultMainNav = $this->getNavigationItemsFromDatabase('mainNavItems');
            $this->resultSubNav = $this->getNavigationItemsFromDatabase('subNavItems');
            $this->resultSmallMainNav = $this->getNavigationItemsFromDatabase('smallMainNavItems');
            $this->resultSmallSubNav = $this->getNavigationItemsFromDatabase('smallSubNavItems');
            include 'views/main-navigation-screens-1171px-up.php';
            include 'views/main-navigation-screens-1170px-down.php';
        }

        if ($pageName == 'Basket' || $pageName == 'Purchase Completed') {
            $this->resultBasket = $this->getNavigationItemsFromDatabase('basketMainNavItems');
            $this->resultBasketSmallNav = $this->getNavigationItemsFromDatabase('basketSmallMainNavItems');
            include 'views/basket-navigation.php';
        }
    }

    private function getNavigationItemsFromDatabase($navigationType): PDOStatement
    {
        $dbConn = $this->dbConn;
        return $dbConn->query("SELECT * FROM $navigationType ORDER BY id");
    }
}
