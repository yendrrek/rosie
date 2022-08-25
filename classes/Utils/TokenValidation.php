<?php

namespace Rosie\Utils;

class TokenValidation
{
    public function validateToken(): bool
    {
        if (empty($_POST['tokenCsrf']) || !hash_equals($_SESSION['tokenCsrf'], $_POST['tokenCsrf'])) {
            return false;
        }
        return true;
    }
}
