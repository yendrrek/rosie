<?php

namespace Rosie\Utils;

class ContentSecurityPolicyDirectives
{
    private string $fallback = "default-src 'self'";
    private string $localhost = 'ws://127.0.0.1:35729';
    private string $googleFonts1 = 'https://fonts.gstatic.com';
    private string $googleFonts2 = 'https://fonts.googleapis.com';
    private string $fontawesome = 'https://*.fontawesome.com';
    private string $jQuery = 'https://code.jquery.com';
    private string $stylesheets = "style-src 'self'";
    private string $hash = 'sha256-e4dj6mtbjBQjHp/lLVoNY4D2OIjnCFGVCzJjSK8MRvo=';
    private string $inline = "'unsafe-inline';";
    private string $payPal = 'https://*.paypal.com';
    private string $images = "img-src 'self'";
    private string $data = 'data: https:';
    private string $forms = "form-action 'self'";
    private string $noFrames = "frame-ancestors 'none'";
    private string $javaScript = "script-src 'self'";

    public function __construct(private Token $token)
    {
    }

    protected function getDirectives($currentPageUrl): array
    {
        $noncePayPalSdk = $noncePayPalSmartBtn = $this->token->setPayPalNonces();

        $contactAndShopPagesDirectives = $otherPagesDirectives = [
            $this->fallback,
            $this->localhost,
            $this->googleFonts1,
            $this->fontawesome,
            "$this->jQuery;",
            $this->stylesheets,
            $this->googleFonts2,
            $this->inline
        ];

        $basketPageDirectives = [
            $this->javaScript,
            $this->localhost,
            $this->googleFonts1,
            $this->fontawesome,
            $this->jQuery,
            $this->payPal,
            "'nonce-$noncePayPalSdk'",
            "'nonce-$noncePayPalSmartBtn'",
            "$this->hash;",
            $this->stylesheets,
            $this->googleFonts2,
            $this->inline,
            $this->images,
            "$this->data;",
            "$this->forms;",
            "$this->noFrames;"
        ];

        if (str_contains($currentPageUrl, 'contact') || str_contains($currentPageUrl, 'shop')) {
            $contactAndShopPagesDirectives[] = $this->forms;
            return $contactAndShopPagesDirectives;
        }

        if (str_contains($currentPageUrl, 'basket')) {
            return $basketPageDirectives;
        }

        return $otherPagesDirectives;
    }
}
