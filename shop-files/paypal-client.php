<?php
namespace Sample;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

require '../classes/EnvironmentVariablesValidation.php'; 

\EnvironmentVariablesValidation::validatePayPalEnvVars();
$payPalEnvironment = \EnvironmentVariablesValidation::$payPalEnvironment;
$pathToClass = 'vendor/paypal/paypal-checkout-sdk/lib/PayPalCheckoutSdk/Core/';
if ($payPalEnvironment === 'sandbox') {
    require_once $pathToClass . 'SandboxEnvironment.php';
} elseif ($payPalEnvironment === 'production') {
    require_once $pathToClass . 'ProductionEnvironment.php';
} else {
    error_log('PayPal environment not set at rosiepiontek.com in paypal-client.php', 1, 'yendrrek@gmail.com');
}

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /* Returns PayPal HTTP client instance with environment that has access credentials context. 
    This instance invokes PayPal APIs, provided the credentials have access. */

    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    // Set up and return PayPal PHP SDK environment with PayPal access credentials.
    public static function environment()
    {
        \EnvironmentVariablesValidation::validatePayPalEnvVars();
        $payPalEnvironment = \EnvironmentVariablesValidation::$payPalEnvironment;
        $clientId = \EnvironmentVariablesValidation::$payPalClientId;
        $clientSecret = \EnvironmentVariablesValidation::$payPalClientSecret;
        if ($payPalEnvironment === 'sandbox') {
            return new SandboxEnvironment($clientId, $clientSecret);
        } elseif ($payPalEnvironment === 'production') {
            return new ProductionEnvironment($clientId, $clientSecret);
        }
    }
}