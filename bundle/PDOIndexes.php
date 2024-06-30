<?php

#[Attribute]
class PDOIndexes
{
    public function __construct(
        public ?string $type = null
    ) { }
}