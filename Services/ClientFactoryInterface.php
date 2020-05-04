<?php

namespace Arris\HttpClientBundle\Services;

use Psr\Http\Client\ClientInterface;

interface ClientFactoryInterface
{
    public function create(): ClientInterface;
}