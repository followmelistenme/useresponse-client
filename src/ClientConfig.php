<?php

namespace UseresponseClient;

class ClientConfig
{
    public const API_VERSION_LATEST = '7.0';

    private string $authToken;

    private string $hostname;

    private string $apiVersion;

    private int $connectionTimeout;

    private bool $useSSL;

    private string $userAgent;

    public function __construct(string $authToken, string $hostname, int $connectionTimeout, bool $useSSL, string $userAgent)
    {
        $this->authToken = $authToken;
        $this->hostname = $hostname;
        $this->connectionTimeout = $connectionTimeout;
        $this->useSSL = $useSSL;
        $this->userAgent = $userAgent;
        $this->apiVersion = static::API_VERSION_LATEST;
    }

    public function setApiVersion(string $version): self
    {
        $this->apiVersion = $version;
        return $this;
    }

    public function toGuzzleConfigMap(): array
    {
        return [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'user-agent' => $this->userAgent,
                'Authorization' => $this->authToken,
                'base_uri' => sprintf('https://%s/api/%s/', $this->hostname, $this->apiVersion),
                'verify' => $this->useSSL,
                'connect_timeout' => $this->connectionTimeout,
            ]
        ];
    }
}
