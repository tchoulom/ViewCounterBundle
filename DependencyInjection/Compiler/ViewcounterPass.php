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

namespace Tchoulom\ViewCounterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ViewcounterPass.
 */
class ViewcounterPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig('tchoulom_view_counter');

        $viewcounterNodeConfig = $this->getViewCounterNodeConfig($configs);
        $statsNodeConfig = $this->getStatsNodeConfig($configs);

        $viewcounterNodeConfigDefinition = $container->getDefinition('tchoulom.viewcounter_node_config');
        $statisticsNodeConfigDefinition = $container->getDefinition('tchoulom.statistics_node_config');

        $viewcounterNodeConfigDefinition->replaceArgument(0, $viewcounterNodeConfig);
        $statisticsNodeConfigDefinition->replaceArgument(0, $statsNodeConfig);
    }

    /**
     * Gets the view counter node configuration
     *
     * @param array $configs
     *
     * @return array
     */
    public function getViewCounterNodeConfig(array $configs)
    {
        $configs = $configs[0];
        $viewcounterNode = $configs['view_counter'];

        return $viewcounterNode;
    }

    /**
     * Gets the stats node configuration
     *
     * @param array $configs
     *
     * @return array
     */
    public function getStatsNodeConfig(array $configs)
    {
        $configs = $configs[0];
        $statsNode = $configs['statistics'];

        return $statsNode;
    }
}