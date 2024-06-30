<?php

class LoginRequest extends RequestHandler
{
    protected $email;

    protected $password;

    public function __construct()
    {
        $this->fillProperty();
        $this->validate();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}