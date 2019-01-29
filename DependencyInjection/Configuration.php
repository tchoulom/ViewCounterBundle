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
                ->arrayNode('view_interval')
                    ->children()
                        ->integerNode('unique_view')->defaultValue(1)->info('Unique view.')->end()
                        ->integerNode('daily_view')->defaultValue(1)->info('Dayly view.')->end()
                        ->integerNode('hourly_view')->defaultValue(1)->info('Hourly view.')->end()
                        ->integerNode('weekly_view')->defaultValue(1)->info('Weekly view.')->end()
                        ->integerNode('monthly_view')->defaultValue(1)->info('Monthly view.')->end()
                    ->end()
                 ->end()
            ->end();

        return $treeBuilder;
    }
}
