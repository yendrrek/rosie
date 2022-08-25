<?php

namespace Rosie\Controllers;

use Rosie\DependenciesContainers\ArtworkDepCont;
use Rosie\Utils\PageName;
use Rosie\Utils\PageTitle;

class Artwork
{
    // All the logic and inserting the content runs here. It is not passed from anywhere else,
    // as otherwise I'm running into issues with unclosed PDO Statements

    public function __construct(private ArtworkDepCont $artworkDepCont)
    {
    }

    public function runPage(): void
    {
        $pageName = PageName::getPageName();

        $this->getSlideshow($pageName);
        $this->getThumbnailImages($pageName);
    }

    private function getSlideshow($pageName): void
    {
        $query = "CALL getSlideshowImgs('$pageName')";
        $resultSlideshow = $this->artworkDepCont->contentDatabaseQuery->getContentFromDatabase($query);

        include 'views/slideshow.php';
    }

    private function getThumbnailImages($pageName): void
    {
        $pageTitle = PageTitle::getPageTitle();

        $query = "CALL getThumbnailImgs('$pageName')";
        $resultThumbnailImages = $this->artworkDepCont->contentDatabaseQuery->getContentFromDatabase($query);

        include 'views/thumbnail-imgs.php';
    }
}
