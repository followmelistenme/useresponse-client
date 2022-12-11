<?php

namespace UseresponseClient\Exceptions;

use Psr\Http\Message\StreamInterface;
use UseresponseClient\HttpResponses;

class HttpBadRequestException extends AbstractClientException
{
    public function __construct(?StreamInterface $response)
    {
        parent::__construct('Bad request', HttpResponses::HTTP_BAD_REQUEST, $response);
    }
}
