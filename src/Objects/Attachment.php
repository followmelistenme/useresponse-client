<?php

namespace UseresponseClient\Objects;

class Attachment {
    private string $name;

    private string $body;

    public function __construct(string $name, string $body)
    {
        $this->name = $name;
        $this->body = $body;
    }

    public function toClientFormat(): array
    {
        return [
            'name' => $this->name,
            'body' => $this->body,
        ];
    }
}
