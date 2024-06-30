<?php

trait RouteSeeker
{
    private function findRoute($object) : ?string
    {
        $reflection = new ReflectionClass($object);
        $methods = $reflection->getMethods();
        $auth = new Auth();

        foreach ($methods as $method) {
            $properties = new ReflectionMethod($object, $method->getName());

            foreach ($properties->getAttributes() as $property) {
                $attributes = $property->getArguments();

                if ($attributes['path'] == $_SERVER['REQUEST_URI']) {
                    if (isset($attributes['roles'])) {
                        if (!$auth->checkCredentials($attributes['roles'])) {
                            $this->status_code = 401;
                            return null;
                        }
                    }

                    return $method->getName();
                }
            }
        }
        return null;
    }
}