<?php

use Psr\Http\Message\MessageInterface;

class UseResponseObjectCreated
{
    private string $type;

    private string $ownership;

    private string $title;

    public function __construct(MessageInterface $response)
    {
        $responseArray = json_decode($response->getBody()->getContents(), true);
        $this->type = $responseArray['success']['type']['title']['single'];
        $this->ownership = $responseArray['success']['ownership'];
        $this->title = $responseArray['success']['title'];
    }
}
