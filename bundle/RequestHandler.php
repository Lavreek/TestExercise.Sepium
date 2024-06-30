<?php

abstract class RequestHandler
{
    protected function fillProperty()
    {
        foreach ($_POST as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    protected function validate(): void
    {
        $properties = get_class_vars(get_class($this));

        foreach ($properties as $propertyName => $propertyPlug) {
            if (empty($this->{$propertyName})) {
                throw new Exception("{$propertyName} field cannot be empty.", 400);
            }
        }
    }
}