<?php

namespace UseresponseClient\Exceptions;

use Psr\Http\Message\StreamInterface;

abstract class AbstractClientException extends \Exception
{

    protected StreamInterface|null $response;

    public function __construct(string $message, int $httpCode, ?StreamInterface $response, \Throwable $previous = null)
    {
        parent::__construct($message, $httpCode, $previous);
        $this->response = $response;
    }

    public function getResponse(): ?StreamInterface
    {
        return $this->response;
    }
}
