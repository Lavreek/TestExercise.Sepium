<?php

class UserRequest
{
    protected $id = 'NULL';

    protected $name;

    protected $email;

    protected $password;

    public function __construct()
    {
        $this->fillProperty();
        $this->validate();
    }

    private function fillProperty()
    {
        foreach ($_POST as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    private function validate(): void
    {
        $properties = get_class_vars('UserRequest');

        foreach ($properties as $propertyName => $propertyPlug) {
            if (empty($this->{$propertyName})) {
                throw new Exception("{$propertyName} field cannot be empty.", 400);
            }
        }
    }

    public function getId()
    {
        return $this->id;
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