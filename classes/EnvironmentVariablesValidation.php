<?php
class EnvironmentVariablesValidation
{
    public static $database;
    public static $host;
    public static $contactFormAddressee;
    public static $ownerEmergencyEmail;
    public static $password;
    public static $payPalClientId;
    public static $payPalClientSecret;
    public static $payPalEnvironment;
    public static $sellerEmail;
    public static $sellerEmailPassword;
    public static $sellerEmailUsername;
    public static $sellerMobile;
    public static $sellerPhone;
    public static $user;

    public static function validatePayPalEnvVars()
    {
        $payPalEnvVarsNotWorking = (
            getenv('PAYPAL_ENVIRONMENT') === false ||
            getenv('PAYPAL_CLIENT_ID') === false ||
            getenv('PAYPAL_CLIENT_SECRET') === false
        );

        if ($payPalEnvVarsNotWorking) {
            echo '<script>alert("Unfortunately, there is a problem with accepting on-line payments at the moment.\nIt is being fixed, so please come back later.\n\nAlternatively, use the contact page to inquire about other forms of ordering.\n\nI apologise for the inconvenience.\n\nRosie Piontek")</script>';
        } else {
            self::$payPalEnvironment = getenv('PAYPAL_ENVIRONMENT');
            self::$payPalClientId = getenv('PAYPAL_CLIENT_ID');
            self::$payPalClientSecret = getenv('PAYPAL_CLIENT_SECRET');
        }
    }

    public static function validatePHPMailerEnvVars()
    {
        $PHPMailerEnvVarsNotWorking = (
            getenv('SELLER_EMAIL_USERNAME') === false ||
            getenv('SELLER_EMAIL_PASSWORD') === false ||
            getenv('SELLER_EMAIL') === false ||
            getenv('SELLER_PHONE') === false ||
            getenv('SELLER_MOBILE') === false
        );

        if ($PHPMailerEnvVarsNotWorking) {
            error_log('Purchase confirmation email not sent to client. Env vars not working at rosiepiontek.com', 1,
                'yendrrek@gmail.com');
        } else {
            self::$sellerEmailUsername = getenv('SELLER_EMAIL_USERNAME');
            self::$sellerEmailPassword = getenv('SELLER_EMAIL_PASSWORD');
            self::$sellerEmail = getenv('SELLER_EMAIL');
            self::$sellerPhone = getenv('SELLER_PHONE');
            self::$sellerMobile = getenv('SELLER_MOBILE');
        }
    }

    public static function validateDbConnEnvVars()
    {
        $dbConnEnvVarsNotWorking = (
            getenv('HOST') === false ||
            getenv('DATABASE') === false ||
            getenv('USER') === false ||
            getenv('PASSWORD') === false
        );

        if ($dbConnEnvVarsNotWorking) {
            error_log('Problem with connecting to the database. Env vars not working at rosiepiontek.com', 1,
                'yendrrek@gmail.com');
        } else {
            self::$host = getenv('HOST');
            self::$database = getenv('DATABASE');
            self::$user = getenv('USER');
            self::$password = getenv('PASSWORD');
            self::$ownerEmergencyEmail = getenv('OWNER_EMERGENCY_EMAIL');
        }
    }

    public static function validateContactFormAddressee()
    {
        $addresseeEnvVarNotWorking = (getenv('ContactForm_ADDRESSEE') === false);

        if ($addresseeEnvVarNotWorking) {
            error_log('Env var with email of owner not working at rosiepiontek.com', 1,
                'yendrrek@gmail.com');
        } else {
            self::$contactFormAddressee = getenv('ContactForm_ADDRESSEE');
        }
    }
} 
