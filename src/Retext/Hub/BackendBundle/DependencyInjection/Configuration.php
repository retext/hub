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
            ->end();
        return $treeBuilder;
    }
}
