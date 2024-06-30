<?php

#[Attribute]
class Routing
{
    public function __construct(
        public string $path,
        public array $roles = []
    )
    {

    }
}