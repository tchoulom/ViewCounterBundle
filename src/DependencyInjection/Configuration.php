<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@gmail.com>
 *
 * (c) Ernest TCHOULOM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchoulom\ViewCounterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Tchoulom\ViewCounterBundle\TchoulomViewCounterBundle;

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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('tchoulom_view_counter');
        $supportedInterval = implode(', ', TchoulomViewCounterBundle::SUPPORTED_STRATEGY);

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('view_counter')
                    ->isRequired()->info('Allows to define the Viewcounter information.')
                    ->children()
                        ->scalarNode('view_strategy')->defaultValue('daily_view')->info('Defines the view strategy.')
                            ->validate()
                                ->ifNotInArray(TchoulomViewCounterBundle::SUPPORTED_STRATEGY)
                                ->thenInvalid('Invalid view strategy name %s. You must choose one of the following values: '. $supportedInterval)
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('statistics')
                    ->children()
                        ->booleanNode('enabled')->isRequired()->defaultValue(false)->info('Defines whether to use statistics.')->end()
                        ->scalarNode('stats_file_name')->isRequired()->info('Defines the name of the statistics file.')->end()
                        ->scalarNode('stats_file_extension')->isRequired()->info('Defines the extension of the statistics file.')->end()
                    ->end()
                ->end()
                ->arrayNode('storage')
                    ->children()
                        ->scalarNode('engine')->info('Allows to define the Storage engine name.')->end()
                    ->end()
                ->end()
                ->arrayNode('geolocation')
                    ->children()
                        ->scalarNode('geolocator_id')->info('Allows to define the Geolocation service identifier.')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
