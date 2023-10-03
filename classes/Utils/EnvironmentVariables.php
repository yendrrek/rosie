<?php

namespace Rosie\Utils;

class EnvironmentVariables
{
    public static string $database = '';
    public static string $host = '';
    public static string $ownerEmergencyEmail = '';
    public static string $password = '';
    public static string $payPalClientId = '';
    public static string $payPalClientSecret = '';
    public static string $environment = '';
    public static string $mailtrapTestToEmail = '';
    public static string $rosieEmail = '';
    public static string $sellerMobile = '';
    public static string $sellerPhone = '';
    public static string $user = '';
    public static string $logFilePath = '';
    public static string $purchaseConfirmationEmailPath = '';
    public static string $emailUserName = '';
    public static string $emailPassword = '';
    public static string $emailHost = '';

    public static function getEnvVars(): void
    {
        self::$database = getenv('DATABASE');
        self::$host = getenv('HOST');
        self::$ownerEmergencyEmail = getenv('OWNER_EMERGENCY_EMAIL');
        self::$password = getenv('PASSWORD');
        self::$payPalClientId = getenv('PAYPAL_CLIENT_ID');
        self::$payPalClientSecret = getenv('PAYPAL_CLIENT_SECRET');
        self::$environment = getenv('ENVIRONMENT');
        self::$mailtrapTestToEmail = getenv('MAILTRAP_TEST_TO_EMAIL');
        self::$rosieEmail = getenv('ROSIE_EMAIL');
        self::$sellerMobile = getenv('SELLER_MOBILE');
        self::$sellerPhone = getenv('SELLER_PHONE');
        self::$user = getenv('USER');
        self::$logFilePath = getenv('CUSTOM_LOG_FILE_PATH');
        self::$purchaseConfirmationEmailPath = getenv('PURCHASE_CONFIRMATION_EMAIL_PATH');
        self::$emailUserName = getenv('EMAIL_USERNAME');
        self::$emailPassword = getenv('EMAIL_PASSWORD');
        self::$emailHost = getenv('EMAIL_HOST');
    }
}
