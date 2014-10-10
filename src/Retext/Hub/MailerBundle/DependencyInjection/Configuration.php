<?php

namespace Retext\Hub\MailerBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('retext_hub_mailer');
        $rootNode
            ->children()
                ->scalarNode('from_email')->defaultValue('hub@retext.it')->end()
                ->scalarNode('from_name')->defaultValue('hub.retext.it')->end()
            ->end();
        return $treeBuilder;
    }
}
