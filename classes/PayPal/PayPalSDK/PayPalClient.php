<?php

namespace Rosie\PayPal\PayPalSDK;

use PayPalCheckoutSdk\Core\PayPalEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use Rosie\Utils\EnvironmentVariables;

class PayPalClient
{
    public static function getPayPalClient(): PayPalHttpClient
    {
        return new PayPalHttpClient(self::getPayPalEnvironment());
    }

    public static function getPayPalEnvironment(): ?PayPalEnvironment
    {
        EnvironmentVariables::getEnvVars();

        $environments = [
          'sandbox' => 'SandboxEnvironment',
          'production' => 'ProductionEnvironment'
        ];
        $environment = "PayPalCheckoutSdk\\Core\\{$environments[EnvironmentVariables::$payPalEnvironment]}";

        return new $environment(
            EnvironmentVariables::$payPalClientId,
            EnvironmentVariables::$payPalClientSecret
        );
    }
}
