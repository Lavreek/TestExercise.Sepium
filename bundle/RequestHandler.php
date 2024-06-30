<?php

abstract class RequestHandler
{
    public function toArray() : array
    {
        $array = [];

        foreach ($this->getProperties() as $propertyName => $propertyPlug) {
            $array[$propertyName] = $this->{$propertyName};
        }

        return $array;
    }

    protected function fillProperty() : void
    {
        foreach ($_POST as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    protected function validate() : void
    {
        foreach ($this->getProperties() as $propertyName => $propertyPlug) {
            try {
                if (!isset($this->{$propertyName})) {
                    throw new Exception("{$propertyName} field cannot be empty.", 400);
                }
            } catch (Exception $exception) {
                die($exception->getMessage());
            }
        }
    }

    private function getProperties() : array
    {
        return get_class_vars(get_class($this));
    }
}