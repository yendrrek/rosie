<?php

namespace Rosie\Utils;

class ContentSecurityPolicy extends ContentSecurityPolicyDirectives
{
    public function setContentSecurityPolicyHeader(): void
    {
        $currentPageUrl = $_SERVER['REQUEST_URI'];
        header('Content-Security-Policy: ' . join(' ', $this->getDirectives($currentPageUrl)));
    }
}
