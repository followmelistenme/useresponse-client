<?php

namespace UseresponseClient\Objects;

class Ticket extends UseResponseObject
{
    public const TYPE = 'ticket';

    public function __construct(string $ownership, string $title, string $notifyEmail, string $notifyName, string $content)
    {
        parent::__construct(static::TYPE, $ownership, $title, $notifyEmail, $notifyName, $content);
    }
}
