<?php
class UserId
{
    public $userId;

    public function setUserId()
    {   
        if (session_id() !== null) {
            $this->userId = session_id();
        } else {
            $this->userId = bin2hex(openssl_random_pseudo_bytes(16));
        }
    }
}
