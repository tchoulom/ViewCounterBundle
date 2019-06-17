<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@yahoo.fr>
 *
 * (c) Ernest TCHOULOM <https://www.tchoulom.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchoulom\ViewCounterBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('tchoulom_view_counter');

        $rootNode
            ->children()
                ->arrayNode('statistics')
                    ->children()
                        ->booleanNode('use_stats')->defaultValue(false)->info('indicates whether to use statistics.')->end()
                        ->scalarNode('stats_extension')->isRequired()->defaultValue(false)->info('indicates the extension of the statistics file.')->end()
                    ->end()
                ->end()
                ->arrayNode('view_interval')
                    ->children()
                        ->booleanNode('increment_each_view')->defaultValue(false)->info('Increment each view.')->end()
                        ->booleanNode('unique_view')->defaultValue(false)->info('Unique view.')->end()
                        ->booleanNode('daily_view')->defaultValue(true)->info('Dayly view.')->end()
                        ->booleanNode('hourly_view')->defaultValue(false)->info('Hourly view.')->end()
                        ->booleanNode('weekly_view')->defaultValue(false)->info('Weekly view.')->end()
                        ->booleanNode('monthly_view')->defaultValue(false)->info('Monthly view.')->end()
                    ->end()
                 ->end()
            ->end();

        return $treeBuilder;
    }
}
