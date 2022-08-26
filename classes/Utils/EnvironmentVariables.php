<?php

namespace Rosie\Utils;

class EnvironmentVariables
{
    public static string $database = '';
    public static string $host = '';
    public static string $contactFormAddressee = '';
    public static string $ownerEmergencyEmail = '';
    public static string $password = '';
    public static string $payPalClientId = '';
    public static string $payPalClientSecret = '';
    public static string $payPalEnvironment = '';
    public static string $sellerEmail = '';
    public static string $sellerEmailPassword = '';
    public static string $sellerEmailUsername = '';
    public static string $sellerMobile = '';
    public static string $sellerPhone = '';
    public static string $user = '';

    public static function getEnvVars(): void
    {
        self::$database = getenv('DATABASE');
        self::$host = getenv('HOST');
        self::$contactFormAddressee = getenv('ContactForm_ADDRESSEE');
        self::$ownerEmergencyEmail = getenv('OWNER_EMERGENCY_EMAIL');
        self::$password = getenv('PASSWORD');
        self::$payPalClientId = getenv('PAYPAL_CLIENT_ID');
        self::$payPalClientSecret = getenv('PAYPAL_CLIENT_SECRET');
        self::$payPalEnvironment = getenv('PAYPAL_ENVIRONMENT');
        self::$sellerEmail = getenv('SELLER_EMAIL');
        self::$sellerEmailPassword = getenv('SELLER_EMAIL_PASSWORD');
        self::$sellerEmailUsername = getenv('SELLER_EMAIL_USERNAME');
        self::$sellerMobile = getenv('SELLER_MOBILE');
        self::$sellerPhone = getenv('SELLER_PHONE');
        self::$user = getenv('USER');
    }
}
