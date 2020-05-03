<?php

namespace Arris\HttpClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('arris_http_client');
        $rootNode ->children()
            ->scalarNode('client_http')->cannotBeEmpty()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
