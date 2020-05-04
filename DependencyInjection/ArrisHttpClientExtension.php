<?php
namespace Arris\HttpClientBundle\DependencyInjection;

use Arris\HttpClientBundle\Services\Hello;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;


class ArrisHttpClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('client_factory', $config['client_factory']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $this->loadClientHttp($container, $config['client_factory']);
    }

    private function loadClientHttp(ContainerBuilder $container, string $clientFactory)
    {
        $hello = new Definition(Hello::class, [new Reference('Symfony\Component\HttpClient\Psr18Client')]);
        $container->setDefinition('hello_service', $hello);
        $container->setAlias(Hello::class, 'hello_service');
    }
}