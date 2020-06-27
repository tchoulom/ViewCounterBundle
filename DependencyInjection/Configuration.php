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
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('tchoulom_view_counter');
        $supportedInterval = implode(', ', TchoulomViewCounterBundle::SUPPORTED_STRATEGY);

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('statistics')
                    ->children()
                        ->booleanNode('use_stats')->isRequired()->defaultValue(false)->info('indicates whether to use statistics.')->end()
                        ->scalarNode('stats_file_name')->isRequired()->info('indicates the name of the statistics file.')->end()
                        ->scalarNode('stats_file_extension')->isRequired()->info('indicates the extension of the statistics file.')->end()
                    ->end()
                ->end()
                ->arrayNode('view_counter')
                    ->children()
                        ->scalarNode('view_strategy')->defaultValue('daily_view')->info('indicates the view strategy.')
                         ->validate()
                            ->ifNotInArray(TchoulomViewCounterBundle::SUPPORTED_STRATEGY)
                            ->thenInvalid('Invalid view strategy name %s. You must choose one of the following values: '. $supportedInterval)
                         ->end()
                    ->end()
                 ->end()
            ->end();

        return $treeBuilder;
    }
}
