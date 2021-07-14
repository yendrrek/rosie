<?php
class ContentSecurityPolicy
{   
    public $noncePayPalSdk;
    public $noncePayPalSmartBtn;
    
    public function __construct() 
    {
        $this->noncePayPalSdk = bin2hex(random_bytes(64));
        $_SESSION['noncePayPalSdk'] = $this->noncePayPalSdk;

        $this->noncePayPalSmartBtn = bin2hex(random_bytes(64));
        $_SESSION['noncePayPalSmartBtn'] = $this->noncePayPalSmartBtn;
    }

    public function setContentSecurityPolicyHeaders()
    {
        $currentPage = '';
        $contactOrShopPageIsLoaded = $basketPageIsLoaded = false;

        $currentPage = $_SERVER['REQUEST_URI'];

        $contactOrShopPageIsLoaded = (
            strpos($currentPage, 'contact') !== false ||
            strpos($currentPage, 'shop') !== false
        );
        $basketPageIsLoaded = (strpos($currentPage, 'basket') !== false);

        if ($contactOrShopPageIsLoaded) {
            $this->setContactOrShopPageHeader();            
        } elseif ($basketPageIsLoaded) {
            $this->setBasketPageHeader();
        } else {
            $this->setOtherPagesHeader();   
        }
    }

    private function setContactOrShopPageHeader()
    {
        header("Content-Security-Policy: default-src 'self' ws://127.0.0.1:35729 https://fonts.gstatic.com https://*.fontawesome.com https://code.jquery.com; style-src 'self' https://fonts.googleapis.com 'unsafe-inline'; form-action 'self';");
    }

    private function setBasketPageHeader()
    {
        header("Content-Security-Policy: script-src 'self' ws://127.0.0.1:35729 https://fonts.gstatic.com  https://*.fontawesome.com https://code.jquery.com https://*.paypal.com 'nonce-$this->noncePayPalSdk' 'nonce-$this->noncePayPalSmartBtn' 'sha256-e4dj6mtbjBQjHp/lLVoNY4D2OIjnCFGVCzJjSK8MRvo='; style-src 'self' https://fonts.googleapis.com 'unsafe-inline'; img-src 'self' data: https:; form-action 'self'; frame-ancestors 'none';");
    }

    private function setOtherPagesHeader()
    {
        header("Content-Security-Policy: default-src 'self' ws://127.0.0.1:35729 https://*.fontawesome.com https://code.jquery.com  https://fonts.gstatic.com; style-src 'self' https://fonts.googleapis.com 'unsafe-inline';");
    }
}