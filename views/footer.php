<?php
if (str_contains($pageTitle, 'Shop')) :
    include 'includes/postage-payments-returns-info-activator.html';
endif;
include 'includes/back-to-top-btn.html';
?>
    
    <div class="push"></div> <!-- Keeps the footer always at the bottom. -->
</div> <!-- Closing tag for all the content above the footer. The opening tag is in 'head.php'. -->
<footer class="footer">
    <span class="copyright">&copy; <?php echo date('Y'); ?> Rosie Piontek</span>
    <a class="fab fa-instagram link link_visited link_instagram link_instagram_hover footer__link
    link_instagram_outline" href="https://www.instagram.com/rosiepiontekart/?hl=en" target="_blank"></a>
</footer>
<script src="../scripts/explorer-alert.js"></script>
<script type="module" src="../scripts/main.js"></script>

<?php
if (str_contains($pageTitle, 'Basket')) :
    if (!empty($_SESSION['basket'])) :
        include 'scripts/pay-pal/paypal-smart-btn.php';
    endif;
endif
?>

<!-- The opening tags are in 'head.php'. -->
</body>
</html>