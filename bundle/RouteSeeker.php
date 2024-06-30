<?php

trait RouteSeeker
{
    private function findRoute($object) : ?string
    {
        $reflection = new ReflectionClass($object);
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {
            $properties = new ReflectionMethod($object, $method->getName());

            foreach ($properties->getAttributes() as $property) {
                $attributes = $property->getArguments();

                preg_match_all('#(.*)?({int}|{string})#', $attributes['path'], $matches);

                if (!empty($matches[0] && str_contains($_SERVER['REQUEST_URI'], $matches[1][0])) ) {
                    var_dump($matches);

die();
                }

                if ($attributes['path'] == $_SERVER['REQUEST_URI']) {

                    return $method->getName();
                }
            }
        }
        return null;
    }
}