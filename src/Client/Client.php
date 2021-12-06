<?php

namespace App\Client;

use Exception;
use GuzzleHttp;

abstract class Client
{
    /**
     * @var GuzzleHttp\Client
     */
    private GuzzleHttp\Client $client;

    /**
     * @var null|string
     */
    private ?string $baseUrl;

    /**
     * @var array
     */
    private array $options;

    /**
     * @var array
     */
    private array $responseHeaders;

    /**
     * @var null|string
     */
    private ?string $url;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(['verify' => false]);
        $this->options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ];
    }

    /**
     * Verify if the base url is not configured.
     *
     * @throws Exception
     */
    private function isBaseUrlEmpty()
    {
        if (is_null($this->baseUrl)) {
            throw new Exception("Base URL is not configured.");
        }
    }

    /**
     * Set the client base url
     *
     * @param string $baseUrl Client base url.
     * @return void
     */
    protected function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * Get the client url.
     *
     * @return string|null
     */
    protected function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Get the client object.
     *
     * @return GuzzleHttp\Client
     */
    protected function getClient(): GuzzleHttp\Client
    {
        return $this->client;
    }

    /**
     * Set the client headers by option:value
     *
     * @param string $option
     * @param string $value
     */
    protected function setHeaders(string $option, string $value)
    {
        $this->options['headers'][$option] = $value;
    }

    /**
     * Get the response headers
     *
     * @return array
     */
    protected function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    /**
     * Set the response headers.
     *
     * @param array $headers
     */
    protected function setResponseHeaders(array $headers)
    {
        $this->responseHeaders = $headers;
    }

    /**
     * Set the client url.
     *
     * @param string $request Request data to set the client url.
     * @throws Exception
     */
    protected function setUrl(string $request)
    {
        $this->isBaseUrlEmpty();
        $this->url = $this->baseUrl . $request;
    }

    /**
     * Verify if the request type was given.
     *
     * @param string|null $requestType Request type.
     * @throws Exception
     */
    protected function verifyRequestType(string $requestType = null)
    {
        if (is_null($requestType)) {
            throw new Exception('Request type is required.');
        }
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return $this->options;
    }
}
