<?php

namespace Arris\HttpClientBundle\Client;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

class HttpClient implements HttpClientInterface
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $stream
    )
    {
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function post(string $uri, array $body = [], array $headers = []): ResponseInterface
    {
        $request = $this->createRequest('POST', $uri, $body, $headers);

        return $this->client->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function put(string $uri, array $body = [], array $headers = []): ResponseInterface
    {
        $request = $this->createRequest('PUT', $uri, $body, $headers);

        return $this->client->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function patch(string $uri, array $body = [], array $headers = []): ResponseInterface
    {
        $request = $this->createRequest('PATCH', $uri, $body, $headers);

        return $this->client->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function get(string $uri, array $params = [], array $headers = []): ResponseInterface
    {
        $uri = $this->createUriWithParams($uri, $params);
        $request = $this->createRequest('GET', $uri, [], $headers);

        return $this->client->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function delete(string $uri, array $params = [], array $headers = []): ResponseInterface
    {
        $uri = $this->createUriWithParams($uri, $params);
        $request = $this->createRequest('DELETE', $uri, [], $headers);

        return $this->client->sendRequest($request);
    }

    public function createRequest(string $method, string $uri, array $body = [], array $headers = []): RequestInterface
    {
        $request = $this->requestFactory->createRequest($method, $uri);

        if (!empty($body)) {
            $stream = $this->stream->createStream(json_encode($body));
            $stream->seek(0);
            $request = $request->withBody($stream);
            $request = $request->withHeader('Content-Type', 'application/json');
        }

        foreach ($headers as $key => $value) {
            $request = $request->withHeader($key, $value);
        }

        return $request;
    }

    public function createUriWithParams(string $url, array $queryParams = []): string
    {
        $queryParams = array_filter($queryParams, function ($value) {
            return '0' === (string) $value || !empty($value);
        });

        return !empty($queryParams) ? $url.'?'.http_build_query($queryParams) : $url;
    }
}
