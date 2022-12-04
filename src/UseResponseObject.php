<?php

namespace UseresponseClient;

abstract class UseResponseObject
{

    private string $type;

    private string $ownership;

    private string $title;

    public function __construct(string $type, string $ownership, string $title)
    {
        $this->type = $type;
        $this->ownership = $ownership;
        $this->title = $title;
    }

    public function toClientFormat(): array
    {
        return [
            'type' => $this->type,
            'ownership' => $this->ownership,
            'title' => $this->title,
        ];
    }
}
