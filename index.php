<?php

session_start();

require __DIR__ . '/vendor/autoload.php';

use Rosie\Config\DatabaseConnection;
use Rosie\Controllers\Breadcrumbs;
use Rosie\Controllers\Head;
use Rosie\Controllers\Footer;
use Rosie\Controllers\NavigationItemsForDifferentScreenSizes;
use Rosie\Controllers\PageNotFoundContent;
use Rosie\Controllers\PayPalTransactionErrorContent;
use Rosie\Services\Basket\AddingProductBasket;
use Rosie\Services\Basket\BasketDatabase;
use Rosie\Services\Basket\BasketDatabaseDataPreparation;
use Rosie\Services\Basket\BasketFullContent;
use Rosie\Services\Basket\RemovingProductBasket;
use Rosie\Services\Basket\UpdatingProductQtyViaDropDownInBasket;
use Rosie\Services\Contact\ContactFormDatabase;
use Rosie\Services\Contact\ContactFormDatabaseDataPreparation;
use Rosie\Services\Contact\ContactFormErrors;
use Rosie\Services\Contact\ContactFormFields;
use Rosie\Services\Contact\ContactFormSubmission;
use Rosie\Services\Contact\ContactFormValidation;
use Rosie\Services\ContentDatabaseQuery\ContentDatabaseQuery;
use Rosie\Services\PurchaseCompleted\PurchaseCompleted;
use Rosie\Utils\RetailPrices;
use Rosie\Utils\ContentSecurityPolicy;
use Rosie\Utils\EnvironmentVariables;
use Rosie\Utils\FormValidation;
use Rosie\Utils\Logging;
use Rosie\Utils\NameOfClass;
use Rosie\Utils\NewLogger;
use Rosie\Utils\RequestMethod;
use Rosie\Utils\Token;
use Rosie\Utils\TokenValidation;

if (PageNotFoundContent::showPageNotFoundInfo()) {
    return;
}

if (PayPalTransactionErrorContent::showPayPalTransactionErrorInfo()) {
    return;
}

EnvironmentVariables::getEnvVars();

$newLogger = new NewLogger();

$databaseConnection = new DatabaseConnection(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class DatabaseConnection'))
);
$databaseConnection = $databaseConnection->connectToDb();

$contentSecurityPolicy = new ContentSecurityPolicy(
    new Token(
        new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class Token'))
    )
);
$contentSecurityPolicy->setContentSecurityPolicyHeader();

$formValidation = new FormValidation(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class FormValidation')),
    new RequestMethod(),
    new TokenValidation()
);

// Contact Form
$contactFormFields = new ContactFormFields();

$contactFormErrors = new ContactFormErrors($contactFormFields);

$contactFormValidation = new ContactFormValidation(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class ContactFormValidation')),
    $formValidation,
    $contactFormErrors,
    $contactFormFields
);
$contactFormSubmission = new ContactFormSubmission(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class ContactFormSubmission')),
    $contactFormFields
);
$contactFormDatabase = new ContactFormDatabase(
    $databaseConnection,
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class ContactFormDatabase')),
    new ContactFormDatabaseDataPreparation($contactFormFields)
);

// Basket
$clientId = EnvironmentVariables::$payPalClientId;
$_SESSION['productsRetailPrices'] = RetailPrices::getRetailPrices();
$addingProductBasket = new AddingProductBasket(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class AddingProductBasket')),
    $formValidation
);
$removingProductBasket = new RemovingProductBasket(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class RemovingProductBasket'))
);
$updatingProductQtyViaDropDownInBasket = new UpdatingProductQtyViaDropDownInBasket(
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class UpdatingProductQtyViaDropDownInBasket')),
    $formValidation
);
$basketDatabase = new BasketDatabase(
    $databaseConnection,
    new BasketDatabaseDataPreparation(),
    new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class BasketDatabaseDataPreparation'))
);

// Services injected into controllers via dependencies containers.
// Below logic needs to run before parts of a page are inserted.
$containerDependencies = [
    'ArtworkDepCont' => [new ContentDatabaseQuery($databaseConnection)],
    'AboutDepCont' => [new ContentDatabaseQuery($databaseConnection)],
    'ContactDepCont' => [
        new ContentDatabaseQuery($databaseConnection),
        new Token(
            new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class Token'))
        ),
        $contactFormValidation,
        $contactFormSubmission,
        $contactFormDatabase
    ],
    'ShopDepCont' => [
        new ContentDatabaseQuery($databaseConnection),
        new Token(
            new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class Token'))
        )
    ],
    'BasketDepCont' => [
        $addingProductBasket,
        $removingProductBasket,
        $updatingProductQtyViaDropDownInBasket,
        $basketDatabase,
        new BasketFullContent(
            new Token(new Logging($newLogger->injectNewLogger('rosiepiontek.com >> class Token')))
        )
    ],
    'PurchaseCompletedDepCont' => [new PurchaseCompleted()],
    'CaptureTransactionErrorDepCont' => []
];

$dependenciesContainerClassName = NameOfClass::getClassName($instance = null);
$dependenciesContainer = "Rosie\\DependenciesContainers\\$dependenciesContainerClassName";
$dependenciesContainerInstance = new $dependenciesContainer(...$containerDependencies[$dependenciesContainerClassName]);
$dependenciesContainerInstance->runDependencies();

Head::getHead();

$navigationItemsForDifferentScreenSizes = new NavigationItemsForDifferentScreenSizes($databaseConnection);
$navigationItemsForDifferentScreenSizes->getNavigationItemsForDifferentScreenSizes();

Breadcrumbs::getBreadcrumbs();

$contentControllerDependencies = [
    'Artwork' => [$dependenciesContainerInstance],
    'About' => [$dependenciesContainerInstance],
    'Contact' => [$dependenciesContainerInstance],
    'Shop' => [$dependenciesContainerInstance],
    'Basket' => [$dependenciesContainerInstance],
    'PurchaseCompleted' => [$dependenciesContainerInstance]
];

$contentControllerClassName = NameOfClass::getClassName($instance = 'controller');
$contentController = "Rosie\\Controllers\\$contentControllerClassName";
$contentControllerInstance = new $contentController(...$contentControllerDependencies[$contentControllerClassName]);
$contentControllerInstance->runPage();

Footer::getFooter();
