<?php

namespace MO\RPCBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('rpc');

        $rootNode
            ->children()
                ->scalarNode('tag_name')
                    ->defaultValue('rpc.service')
                ->end()
                ->scalarNode('container_service')
                    ->defaultValue('mo.rpc.container')
                ->end()
            ->end();


        return $treeBuilder;
    }
}
