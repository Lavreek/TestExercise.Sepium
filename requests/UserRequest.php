<?php

class UserRequest extends RequestHandler
{
    protected $name;

    protected $email;

    protected $password;

    public function __construct()
    {
        $this->fillProperty();
        $this->validate();
    }

    public function getName()
    {
        return $this->name;
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