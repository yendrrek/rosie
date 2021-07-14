<?php
class Token 
{
    public $tokenCsrf;

    public function __construct() 
    {   
        $this->tokenCsrf = bin2hex(random_bytes(64));
    }
}