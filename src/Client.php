<?php

namespace UseresponseClient;

use GuzzleHttp\RequestOptions;
use Psr\Http\Message\MessageInterface;
use UseresponseClient\Exceptions\HttpBadRequestException;
use UseresponseClient\Objects\UseResponseObject;
use UseresponseClient\Objects\UseResponseObjectCreated;
use UseresponseClient\Exceptions\InternalClientException;

class Client
{
    private \GuzzleHttp\Client $guzzleHttp;

    private string $path;

    private function __construct(\GuzzleHttp\Client $guzzleHttp, string $apiPath, string $apiVersion)
    {
        $this->guzzleHttp = $guzzleHttp;
        $this->path = sprintf('%s/api/%s', $apiPath, $apiVersion);
    }

    public function __clone()
    {
        return;
    }

    public static function initByConfig(ClientConfig $config): self
    {
        $guzzleHttp = new \GuzzleHttp\Client($config->toGuzzleConfigMap());
    
        return new self($guzzleHttp, $config->getApiPath(), $config->getApiVersion());
    }

    /**
     * @throw \UseresponseClient\InternalClientException
     */
    public function createObject(UseResponseObject $useResponseObject): UseResponseObjectCreated
    {
        $options = [RequestOptions::BODY => json_encode($useResponseObject->toClientFormat())];
        try {
            $response = $this->requestPost($this->path .  ResourcePath::OBJECTS, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new InternalClientException($e->getMessage(), $e->getResponse()?->getStatusCode() ?? $e->getCode(), $e->getResponse()?->getBody());
        }

        return new UseResponseObjectCreated($response);
    }
    
    private function requestPost(string $url, array $options): MessageInterface
    {
        $options = array_merge([RequestOptions::HEADERS => ['content-type' => 'application/json']], $options);
        try {
            $response = $this->guzzleHttp->request('POST', $url, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            static::handleResponseError($e);
        }

        return $response;
    }

    private static function handleResponseError(\GuzzleHttp\Exception\RequestException $e)
    {
        $httpStatusCode = $e->getResponse()?->getStatusCode();

        if ($httpStatusCode == null) {
            throw new InternalClientException($e->getMessage(), 0, null, $e);
        }

        switch($e->getResponse()?->getStatusCode()) {
            case HttpResponses::HTTP_BAD_REQUEST:
                throw new HttpBadRequestException($e->getResponse()?->getBody());
            default:
                throw new InternalClientException($e->getMessage(), $e->getResponse()?->getStatusCode(), $e->getResponse()?->getBody());
        }
    }
}
