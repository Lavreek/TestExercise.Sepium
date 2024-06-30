<?php

declare(strict_types=1);

#[Attribute]
class PDOTypes
{
    public function __construct(
        public ?string $type = null,
        public ?int $length = null,
        public bool $nullable = false,
        public bool $primary = false,
        public bool $auto_increment = false
    ) { }
}