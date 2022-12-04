<?php

namespace UseresponseClient;

class Ticket extends UseResponseObject
{
    public const TYPE = 'ticket';

    public function __construct(string $ownership, string $title)
    {
        parent::__construct(static::TYPE, $ownership, $title);
    }
}
