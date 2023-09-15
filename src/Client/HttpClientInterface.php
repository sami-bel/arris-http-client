<?php

namespace Arris\HttpClientBundle\Client;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function post(string $uri, array $body, array $headers = []): ResponseInterface;

    public function put(string $uri, array $body, array $headers = []): ResponseInterface;

    public function patch(string $uri, array $body, array $headers = []): ResponseInterface;

    public function get(string $uri, array $params = [], array $headers = []): ResponseInterface;

    public function delete(string $uri, array $params = [], array $headers = []): ResponseInterface;

    public function createUriWithParams(string $url, array $queryParams = []): string;
}
