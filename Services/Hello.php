<?php

namespace Arris\HttpClientBundle\Services;

use Psr\Http\Client\ClientInterface;

class Hello
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Hello constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface  $client)
    {
        $this->client = $client;
    }

    public function hello(): string
    {
        return 'hello: first bundle function';
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }
}