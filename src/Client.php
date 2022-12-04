<?php

namespace UseresponseClient;

use UseResponseObjectCreated;

class Client
{
    private \GuzzleHttp\Client $guzzleHttp;

    private function __construct(\GuzzleHttp\Client $guzzleHttp)
    {
        $this->guzzleHttp = $guzzleHttp;
    }

    public function __clone()
    {
        return;
    }

    public static function initByClient(\GuzzleHttp\Client $client): self
    {
        return new self($client);
    }

    public static function initByConfig(ClientConfig $config): self
    {
        $guzzleHttp = new \GuzzleHttp\Client($config->toGuzzleConfigMap());
    
        return new self($guzzleHttp);
    }

    public function create(UseResponseObject $useResponseObject): UseResponseObjectCreated
    {
        try {
        $response = $this->guzzleHttp->request('POST', Endpoints::OBJECTS, $useResponseObject->toClientFormat());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return false;
        }

        return new UseResponseObjectCreated($response);
    }
}
