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
        $arguments = $this->buildViewcounterConfigArguments($configs);
        $container->getDefinition('tchoulom.viewcounter_config')->setArguments($arguments);
    }

    /**
     * Builds the viewcounter configuration arguments.
     *
     * @param array $configs
     *
     * @return array
     */
    public function buildViewcounterConfigArguments(array $configs)
    {
        $viewcounterNode = $this->getViewCounterNode($configs);
        $statsNode = $this->getStatsNode($configs);

        return [$viewcounterNode, $statsNode];
    }

    /**
     * Gets the view counter node
     *
     * @param array $configs
     *
     * @return array
     */
    public function getViewCounterNode(array $configs)
    {
        $configs = $configs[0];
        $viewcounterNode = $configs['view_counter'];

        return $viewcounterNode;
    }

    /**
     * Gets the stats node
     *
     * @param array $configs
     *
     * @return array
     */
    public function getStatsNode(array $configs)
    {
        $configs = $configs[0];
        $statsNode = $configs['statistics'];

        return $statsNode;
    }
}