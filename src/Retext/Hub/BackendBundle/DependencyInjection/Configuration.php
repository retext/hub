<?php

namespace Retext\Hub\BackendBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hub_backend');
        $rootNode
            ->children()
                ->scalarNode('clock_expr')->defaultValue('now')->end()
                ->arrayNode('tokens')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('login')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('lifetime')->defaultValue(3600)->end()
                        ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
