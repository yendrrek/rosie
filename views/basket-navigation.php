<header class="header">

<?php
include 'includes/logo.php';
if (!empty($_SESSION['basket'])) :
    include './views/basket-full-navigation.php';
else :
    include './views/empty-basket-navigation.html';
endif;
?>
    
</header>