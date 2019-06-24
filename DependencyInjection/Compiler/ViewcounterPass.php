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
        $viewIntervalNode = $this->getViewIntervalNode($configs);
        $statsNode = $this->getStatsNode($configs);

        return [$viewIntervalNode, $statsNode];
    }

    /**
     * Gets the view interval node
     *
     * @param array $configs
     *
     * @return array
     */
    public function getViewIntervalNode(array $configs)
    {
        $configs = $configs[0];
        $viewIntervalNode = $configs['view_interval'];

        return $viewIntervalNode;
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