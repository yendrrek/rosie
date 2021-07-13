<?php
session_start();

require 'config/db-conn.php';

function loadClasses()
{
    $classLoaded = '';

    spl_autoload_register(function($classToLoad) {
        $classLoaded = stream_resolve_include_path('classes/' . $classToLoad . '.php');
        if ($classLoaded !== false) {
            include $classLoaded;
        }
    });
} 
loadClasses();

$pagesWillIncludeMainNav = $existingPages = [];

$currentPage = $_SERVER['REQUEST_URI'];
$allWorksPageIsLoaded = (strpos($currentPage, 'all-works') !== false);
$geometryPageIsLoaded = (strpos($currentPage, 'geometry') !== false);
$stainedGlassPageIsLoaded = (strpos($currentPage, 'stained-glass') !== false);
$ceramicTilesPageIsLoaded = (strpos($currentPage, 'ceramic-tiles') !== false);
$paintingsPageIsLoaded = (strpos($currentPage, 'paintings') !== false);
$aboutPageIsLoaded = (strpos($currentPage, 'about') !== false);
$contactPageIsLoaded = (strpos($currentPage, 'contact') !==  false);
$shopPageIsLoaded = (strpos($currentPage, 'shop') !==  false);
$basketPageIsLoaded = (strpos($currentPage, 'basket') !==  false);
$purchaseCompletedPageIsLoaded = (strpos($currentPage, 'purchase-completed') !== false);
$purchaseCompletedPageIsNOTLoaded = (strpos($currentPage, 'purchase-completed') === false);
$errorTransactionPageIsNOTLoaded = (strpos($currentPage, 'capture-transaction-error') === false);
$errorTransactionPageIsLoaded = (strpos($currentPage, 'capture-transaction-error') !== false);

$existingPages = [
    $allWorksPageIsLoaded,
    $allWorksPageIsLoaded,
    $geometryPageIsLoaded,
    $stainedGlassPageIsLoaded,
    $ceramicTilesPageIsLoaded,
    $paintingsPageIsLoaded,
    $aboutPageIsLoaded,
    $contactPageIsLoaded,
    $shopPageIsLoaded,
    $basketPageIsLoaded,
    $basketPageIsLoaded,
    $purchaseCompletedPageIsLoaded,
    $errorTransactionPageIsLoaded
];

function checkIfPageExists()
{
    global $existingPages;

    if (in_array(true, $existingPages)) {
        $existingPages = null;
    } else {
        echo '<p>The page requested does not exist.</p><br><br><a href="all-works.php">Go to Homepage</a>';
    }
}
checkIfPageExists();

$contentSecurityPolicy = new ContentSecurityPolicy();
$contentSecurityPolicy->setContentSecurityPolicyHeaders();

$colorOfTAndFullStopInLogo = new ColorOfTAndFullStopInLogo();
$colorOfTAndFullStopInLogo->setTAndFullStopColor();
$colorOfTInLogo = $colorOfTAndFullStopInLogo->colorOfTInLogo;
$colorOfFullStopInLogo = $colorOfTAndFullStopInLogo->colorOfFullStopInLogo;

$pageName = new PageName();
$pageName->setPageName();
$pageTitle = $pageName->pageTitle;
$breadcrumbsPageTitle = $pageName->breadcrumbsPageTitle;
$artworkSectionTitle = $pageName->artworkSectionTitle;
$slideshowSectionTitle1 = $pageName->slideshowSectionTitle1;
$slideshowSectionTitle2 = $pageName->slideshowSectionTitle2;

if ($contactPageIsLoaded) {

    EnvironmentVariablesValidation::validatePHPMailerEnvVars();
    $sellerEmail = EnvironmentVariablesValidation::$sellerEmail;
    $sellerPhone = EnvironmentVariablesValidation::$sellerPhone;
    $sellerMobile = EnvironmentVariablesValidation::$sellerMobile;

    $tokenCsrf = new Token();
    if (!isset($_SESSION['tokenCsrf'])) {
        $_SESSION['tokenCsrf'] = $tokenCsrf->tokenCsrf;
    }
    $tokenCsrf = $_SESSION['tokenCsrf'];

    $contactFormValidation = new ContactFormValidation();
    $contactFormValidation->validateContactForm();
    $senderName = $contactFormValidation->senderName;
    $senderEmail = $contactFormValidation->senderEmail;
    $msg = $contactFormValidation->msg;
    $senderNameError = $contactFormValidation->senderNameError;
    $senderEmailError = $contactFormValidation->senderEmailError;
    $msgError = $contactFormValidation->msgError;
    $generalNotification = $contactFormValidation->generalNotification;
    $msgValidatedWillBeSubmited = $contactFormValidation->msgValidatedWillBeSubmited;

    if ($msgValidatedWillBeSubmited) {

        $contactFormSubmition = new ContactFormSubmition();
        $contactFormSubmition->sendMsg($contactFormValidation);
        $generalNotification = $contactFormSubmition->generalNotification;
        $msgSentWillAmendDb = $contactFormSubmition->msgSentWillAmendDb;

        if ($msgSentWillAmendDb) {

            $contactFormDb = new ContactFormDb($pdo);
            $userId = new UserId();
            $userId->setUserId();
            $contactFormDb->insertContactFormDb($contactFormValidation, $userId);
        }
    }
}
    
if ($shopPageIsLoaded) {

    $tokenCsrf = new Token();
    $tokenCsrf = $tokenCsrf->tokenCsrf;
    $_SESSION['tokenCsrf'] = $tokenCsrf;
}

if ($basketPageIsLoaded) {

    if (isset($_SESSION['tokenCsrf'])) {
        $tokenCsrf = $_SESSION['tokenCsrf'];
    }

    EnvironmentVariablesValidation::validatePayPalEnvVars();
    $clientId = EnvironmentVariablesValidation::$payPalClientId;

    $retailPrices = new RetailPrices();
    $retailPrices->getRetailPrices();
    $productsRetailPrices = $retailPrices->productsRetailPrices;
    $_SESSION['productsRetailPrices'] = $productsRetailPrices;

    $addingProductToBasket = new AddingProductToBasket();
    $addingProductToBasket->addProductToBasket(); 
    $productAddedToBasketWillAmendDbNow = $addingProductToBasket->productAddedToBasketWillAmendDbNow;
    $showStockLimitInfoLightbox = $addingProductToBasket->showStockLimitInfoLightbox;

    $removingProductFromBasket = new RemovingProductFromBasket();
    $removingProductFromBasket->removeProductFromBasket();
    $removedProductFromBasketWillAmendDbNow = $removingProductFromBasket->removedProductFromBasketWillAmendDbNow;

    $updatingQtyViaBasketDropDownMenu = new UpdatingQtyViaBasketDropDownMenu();
    $updatingQtyViaBasketDropDownMenu->updateQtyViaBasketDropDownMenu();
    $updatedQtyWillAmendDbNow = $updatingQtyViaBasketDropDownMenu->updatedQtyWillAmendDbNow;
    $zeroQtySelectedWillAmendDbNow = $updatingQtyViaBasketDropDownMenu->zeroQtySelectedWillAmendDbNow;

    $basketDb = new BasketDb($pdo);

    $userId = new UserId();
    $userId->setUserId();

    if ($productAddedToBasketWillAmendDbNow) {

        $basketDb->addProductToBasketDb($userId);

    } elseif ($removedProductFromBasketWillAmendDbNow || $zeroQtySelectedWillAmendDbNow) {

        $basketDb->removeProductFromBasketDb($userId);

    } elseif ($updatedQtyWillAmendDbNow && !$zeroQtySelectedWillAmendDbNow) {

        $basketDb->updateQtyViaBasketDropDownMenuDb($userId);
    }
}

if ($purchaseCompletedPageIsLoaded) {

    $_SESSION = [];
    session_destroy();
}

if ($errorTransactionPageIsNOTLoaded) {

    include 'views/head.php';
}

$pagesWillIncludeMainNav = [
    $allWorksPageIsLoaded, 
    $geometryPageIsLoaded, 
    $stainedGlassPageIsLoaded, 
    $ceramicTilesPageIsLoaded, 
    $paintingsPageIsLoaded, 
    $aboutPageIsLoaded, 
    $contactPageIsLoaded, 
    $shopPageIsLoaded
];

if  (in_array(true, $pagesWillIncludeMainNav)) {

    $resultMainNav = $pdo->query('SELECT * FROM mainNavItems ORDER BY id ASC');

    $resultSubNav = $pdo->query('SELECT * FROM subNavItems ORDER BY id ASC');

    include 'views/main-navigation-screens-1171px-up.php';

    $resultMainNav = null;
    $resultSubNav = null;

    $resultSmallMainNav = $pdo->query('SELECT * FROM smallMainNavItems ORDER BY id ASC');

    $resultSmallSubNav = $pdo->query('SELECT * FROM smallSubNavItems ORDER BY id ASC'); 

    include 'views/main-navigation-screens-1170px-down.php';

    $resultSmallMainNav = null;
    $resultSmallSubNav = null;

} elseif ($basketPageIsLoaded || $purchaseCompletedPageIsLoaded) {

    $resultBasket = $pdo->query('SELECT * FROM basketMainNavItems ORDER BY id ASC');

    $resultBasketSmallNav = $pdo->query('SELECT * FROM basketSmallMainNavItems ORDER BY id ASC');

    include 'views/basket-navigation.php';

    $resultBasket = null;
    $resultBasketSmallNav = null;
}

if ($purchaseCompletedPageIsNOTLoaded && $errorTransactionPageIsNOTLoaded) {

    include 'views/breadcrumbs.php';
}

$pagesWillIncludeSlideshow = [
    $allWorksPageIsLoaded, 
    $geometryPageIsLoaded, 
    $stainedGlassPageIsLoaded, 
    $ceramicTilesPageIsLoaded, 
    $paintingsPageIsLoaded
];

if (in_array(true, $pagesWillIncludeSlideshow)) {

    $resultSlideshowImgs = $pdo->query("CALL getSlideshowImgs('$artworkSectionTitle')"); 

    include 'views/slideshow.php';

    $resultSlideshowImgs = null;

    $resultThumbnailImgs = $pdo->query("CALL getThumbnailImgs('$artworkSectionTitle')");

    include 'views/thumbnail-imgs.php';

    $resultThumbnailImgs = null;

} elseif ($aboutPageIsLoaded) {

    $resultAbout = $pdo->query('SELECT * FROM aboutContent ORDER BY id ASC');

    include 'views/about-content.php';

    $resultAbout = null;

} elseif ($contactPageIsLoaded) {

    include 'views/contact-form-and-details.php';

} elseif ($shopPageIsLoaded) {

    $resultCards = $pdo->query('CALL getCards()');

    include 'views/shop-content.php';

    $resultCards = null;

} elseif ($basketPageIsLoaded || $purchaseCompletedPageIsLoaded) {

    include 'views/basket-content.php';
}

if ($errorTransactionPageIsNOTLoaded) {

    include 'views/footer.php';

} else {

    include 'views/capture-transaction-error.html';
}