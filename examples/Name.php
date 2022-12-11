<?php

use UseresponseClient\Objects\CustomField;

class Name implements CustomField
{
    private const CUSTOM_FIELD_NAME = 'property_1';

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return static::CUSTOM_FIELD_NAME;
    }

    public function getValue(): string
    {
        return $this->name;
    }
}
