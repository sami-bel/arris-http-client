<?php
namespace Arris\HttpClientBundle\DependencyInjection;

use Arris\HttpClientBundle\Services\Hello;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ArrisHttpClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('client_http', $config['client_http']);
        $this->loadClientHttp($container, $config['client_http']);

    }

    private function loadClientHttp(ContainerBuilder $container, string $httpClientId)
    {
        $hello = new Definition(Hello::class, [$container->getDefinition($httpClientId)]);
        $container->setDefinition('hello_service', $hello);
        $container->setAlias(Hello::class, $hello);
    }

}