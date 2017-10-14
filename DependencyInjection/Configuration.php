<?php

namespace tchoulom\ViewCounterBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('core_view_counter');

        $rootNode
            ->children()
                ->integerNode('day_view')->defaultValue(1)
                    ->info('Day view.')
                ->end()
                ->integerNode('hourly_view')->defaultValue(1)
                    ->info('Hourly view.')
                ->end()
                ->integerNode('weekly_view')->defaultValue(1)
                    ->info('Weekly view.')
                ->end()
                ->integerNode('monthly_view')->defaultValue(1)
                    ->info('Monthly view.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
