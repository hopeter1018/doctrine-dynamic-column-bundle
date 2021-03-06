<?php

namespace HoPeter1018\DoctrineDynamicColumnBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hopeter1018_doctrine_dynamic_column');

        $rootNode
            ->children()
                ->scalarNode('class')
                    ->defaultValue('HoPeter1018\DoctrineDynamicColumnBundle\Entity\DynamicColumnData')
                ->end()
                ->arrayNode('managers')
                    ->defaultValue([])->prototype('scalar')->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
