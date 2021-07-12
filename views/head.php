<?php
if (isset($_SESSION['noncePayPalSdk'])): 
    $noncePayPalSdk = $_SESSION['noncePayPalSdk'];
endif;
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
    <script src="https://kit.fontawesome.com/ad7a1df0ce.js" 
    crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <?php
if (strpos($pageTitle, 'Shop') !== false): 
    ?>

    <script src="fotorama-4.6.4.dev/fotorama.dev.js"></script>
    <link  href="fotorama-4.6.4.dev/fotorama.dev.css" rel="stylesheet">

    <?php
endif;
if (strpos($pageTitle, 'Basket') !== false):
    if (!empty($_SESSION['basket'])):
    ?>

    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo $clientId; ?>&currency=GBP&intent=capture" data-csp-nonce="<?php echo $noncePayPalSdk; ?>" id="paypal-sdk-head-script"></script>

    <?php
    endif;
endif;
if (strpos($pageTitle, 'All Works') !== false):
    ?>

    <link rel="canonical" href="https://rosiepiontek.com">

    <?php
endif;
    ?>

    <link href="styles/hamburger.css" rel="stylesheet">
    <link href="styles/main.css" rel="stylesheet">
    <link rel="icon" href="img/png/paloma.png">
</head>

<body class="body clearfix_after">
    <div class="body__content-above-footer">  <!-- Opening tag for all the content above the footer -->