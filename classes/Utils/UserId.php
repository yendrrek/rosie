<?php

namespace Rosie\Utils;

class UserId
{
    public function getUserId(): string
    {
        return session_id() ?? bin2hex(openssl_random_pseudo_bytes(16));
    }
}
