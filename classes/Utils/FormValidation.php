<?php

namespace Rosie\Utils;

class FormValidation
{
    public function __construct(
        private Logging $logging,
        private RequestMethod $requestMethod,
        private TokenValidation $tokenValidation
    ) {
    }

    public function validateForm($requestedMethodShouldBe, $invalidCsrfTokenMessage = null, $formFilter = null): bool
    {
        $requestMethod = $this->requestMethod->getRequestMethod();
        $isTokenValid = $this->tokenValidation->validateToken();

        if ($requestedMethodShouldBe != $requestMethod || $formFilter) {
            return false;
        }

        if ($requestMethod == 'get') {
            return true;
        }

        if (!$isTokenValid) {
            $this->logging->logMessage('alert', $invalidCsrfTokenMessage);
            return false;
        }
        return true;
    }
}
