<?php

namespace Rosie\Utils;

class RequestMethod
{
    public function getRequestMethod(): string
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' && $_SERVER['REQUEST_METHOD'] != 'GET') {
            return false;
        }

        return $_SERVER['REQUEST_METHOD'] == 'POST' ? 'post' : 'get';
    }
}
