<?php

use Rosie\Utils\EnvironmentVariables;

EnvironmentVariables::getEnvVars();
?>

<!DOCTYPE html>
<html class="html" lang="en-gb" id="top">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Rosie Piontek - Traditional Artist using tempera">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <title><?php echo $pageTitle;?></title>
    <link href="https://fonts.googleapis.com/css?family=Alice%7CForum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ad7a1df0ce.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <?php
    if (str_contains($pageTitle, 'Basket')) :
        if (!empty($_SESSION['basket'])) :
            ?>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo EnvironmentVariables::$payPalClientId; ?>&currency=GBP&intent=capture"
            data-csp-nonce="<?php echo $_SESSION['noncePayPalSdk'] ?? false; ?>" id="paypal-sdk-head-script"></script>

            <?php
        endif;
    endif;
    if (str_contains($pageTitle, 'All Works')) :
        ?>

    <link rel="canonical" href="https://rosiepiontek.com">

        <?php
    endif;
    ?>

    <link href="../styles/hamburger.css" rel="stylesheet">
    <link href="../styles/main.css" rel="stylesheet">
</head>

<body class="body clearfix_after">
    <div class="content-above-footer">  <!-- Opening tag for all the content above the footer -->