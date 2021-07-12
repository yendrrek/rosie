<?php 
if (strpos($pageTitle, 'Shop') !== false):
    include 'includes/postage-payments-returns-info-activator.html';
endif;
include 'includes/back-to-top-btn.html'; 
    ?>
    
    <div class="body__push"></div> <!-- Keeps the footer always at the bottom. -->
</div> <!-- Closing tag for all the content above the footer -->
<footer class="footer body__footer">
	<span class="copyright">&copy; <?php echo date('Y'); ?> Rosie Piontek</span>
	<a class="fab fa-instagram link link_visited link_instagram link_instagram_hover footer__link
    link_instagram_outline" href="https://www.instagram.com/rosiepiontekart/?hl=en" target="_blank"></a>
</footer>
<script src="scripts/explorer-alert.js"></script>
<script type="module" src="scripts/main.js"></script>

<?php
if (strpos($pageTitle, 'Basket') !== false):
    if (!empty($_SESSION['basket'])):
      include 'scripts/paypal-smart-btn-script.php';
    endif;
endif
?>

</body>
</html>