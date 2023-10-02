<?php

namespace Sample;

use Rosie\Utils\EnvironmentVariables;

require '../../classes/Utils/EnvironmentVariables.php';

EnvironmentVariables::getEnvVars();

$environments = [
    'sandbox' => 'SandboxEnvironment.php',
    'production' => 'ProductionEnvironment.php'
];
$pathToClass = '../../vendor/paypal/paypal-checkout-sdk/lib/PayPalCheckoutSdk/Core/';

require_once "$pathToClass{$environments[EnvironmentVariables::$environment]}";

ini_set('error_reporting', E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
