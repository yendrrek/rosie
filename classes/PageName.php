<?php
class PageName 
{
    public $artworkSectionTitle;
    public $breadcrumbsPageTitle;
    public $pageTitle;
    public $slideshowSectionTitle1;
    public $slideshowSectionTitle2;

    public function setPageName()
    {  
        $currentPage = $fixedChunkOfPageTitle = '';
        $isAllWorks = $isGeometry = $isStainedGlass = $isCeramicTiles = $isPaintings =
        $isAbout = $isContact = $isShop = $isBasket = $isPurchaseCompleted = false;
        $existingPages = [];

        $currentPage = $_SERVER['REQUEST_URI'];

        $isAllWorks = (strpos($currentPage, 'all-works') !== false);
        $isGeometry = (strpos($currentPage, 'geometry') !== false);
        $isStainedGlass = (strpos($currentPage, 'stained-glass') !== false);
        $isCeramicTiles = (strpos($currentPage, 'ceramic-tiles') !== false);
        $isPaintings = (strpos($currentPage, 'paintings') !== false);
        $isAbout = (strpos($currentPage, 'about') !== false);
        $isContact = (strpos($currentPage, 'contact') !== false);
        $isShop = (strpos($currentPage, 'shop') !== false);
        $isBasket = (strpos($currentPage, 'basket') !== false);
        $isPurchaseCompleted = (strpos($currentPage, 'purchase-completed') !== false);

        $fixedChunkOfPageTitle = '| Rosie Piontek - Traditional Artist';

        $existingPages = [
            $isAllWorks,
            $isGeometry,
            $isStainedGlass,
            $isCeramicTiles,
            $isPaintings,
            $isAbout,
            $isContact,
            $isShop,
            $isBasket,
            $isPurchaseCompleted
        ];

        switch ($currentPage) {
            case $isAllWorks:
                $this->pageTitle = 'All Works ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'All Works';
                $this->artworkSectionTitle = 'allWorks';
                $this->slideshowSectionTitle1 = 'All Works';
                break;
            case $isGeometry:
                $this->pageTitle = 'Geometry ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'Geometry';
                $this->artworkSectionTitle = 'geometry';
                $this->slideshowSectionTitle1 = 'Geometry';
                break;
            case $isStainedGlass:
                $this->pageTitle = 'Stained Glass ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'Stained Glass';
                $this->artworkSectionTitle = 'stainedGlass';
                $this->slideshowSectionTitle1 = 'Stained';
                $this->slideshowSectionTitle2 = 'Glass';
                break;
            case $isCeramicTiles:
                $this->pageTitle = 'Ceramic Tiles ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'Ceramic Tiles';
                $this->artworkSectionTitle = 'ceramicTiles';
                $this->slideshowSectionTitle1 = 'Ceramic';
                $this->slideshowSectionTitle2 = 'Tiles';
                break;
            case $isPaintings:
                $this->pageTitle = 'Paintings ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'Paintings';
                $this->artworkSectionTitle = 'paintings';
                $this->slideshowSectionTitle1 = 'Paintings';
                break;
            case $isAbout:
                $this->pageTitle = 'About ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'About';
                break;
            case $isContact:
                $this->pageTitle = 'Contact ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'Contact';
                break;
            case $isShop:
                $this->pageTitle = 'Shop ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'Shop';
                break;
            case $isBasket:
                $this->pageTitle = 'Basket ' . $fixedChunkOfPageTitle;
                $this->breadcrumbsPageTitle = 'Basket details';
                break;
            case $isPurchaseCompleted:
                $this->pageTitle = 'Purchase completed ' . $fixedChunkOfPageTitle;
                break;
        }
        if (in_array(true, $existingPages)) {
            $existingPages = null;
        } else {
            $this->pageTitle = 'NOT FOUND';
        }
    }
}