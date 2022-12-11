<?php

namespace UseresponseClient\Objects;

interface CustomField
{
    public function getName(): string;

    public function getValue(): string;
}
