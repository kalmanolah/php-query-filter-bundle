<?php

namespace KalmanOlah\QueryFilterBundle\DependencyInjection;

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
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kalman_olah_query_filter');

        $rootNode
            ->children()
                ->fixXmlConfig('filter_set')
                ->children()
                    ->arrayNode('filter_sets')
                        ->prototype('array')
                            ->children()
                                ->fixXmlConfig('transformer')
                                ->children()
                                    ->arrayNode('transformers')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                                ->fixXmlConfig('filter')
                                ->children()
                                    ->arrayNode('filters')
                                        ->prototype('scalar')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
