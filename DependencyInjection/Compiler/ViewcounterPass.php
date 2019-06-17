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
use Tchoulom\ViewCounterBundle\Exception\RuntimeException;
use Tchoulom\ViewCounterBundle\Model\ViewcounterConfig;
use Tchoulom\ViewCounterBundle\TchoulomViewCounterBundle;

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
        $viewcounterConfig = $container->get('tchoulom.viewcounter_config');;

        $this->checkViewcounterConfigs($viewcounterConfig);
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
        $viewIntervalConfig = $this->getViewIntervalConfigs($configs);
        $statsConfig = $this->getStatsConfigs($configs);
        $viewIntervalName = $this->getViewIntervalName($viewIntervalConfig);
        $useStats = $statsConfig['use_stats'];
        $statsExtension = $statsConfig['stats_extension'];

        return [$viewIntervalName, $useStats, $statsExtension];
    }

    /**
     * Gets the view interval configs
     *
     * @param array $configs
     *
     * @return array
     */
    public function getViewIntervalConfigs(array $configs)
    {
        $configs = $configs[0];
        $viewIntervalConfig = $configs['view_interval'];

        return $viewIntervalConfig;
    }

    /**
     * Gets the stats configs
     *
     * @param array $configs
     *
     * @return array
     */
    public function getStatsConfigs(array $configs)
    {
        $configs = $configs[0];
        $statsConfig = $configs['statistics'];

        return $statsConfig;
    }

    /**
     * Gets the view interval name.
     *
     * @param array $viewIntervalConfig
     *
     * @return mixed
     */
    public function getViewIntervalName(array $viewIntervalConfig)
    {
        $viewIntervalName = array_search(true, $viewIntervalConfig, true);

        return $viewIntervalName;
    }

    /**
     * Checks the viewcounter configuration.
     *
     * @param ViewcounterConfig $viewcounterConfig
     *
     * @return bool
     */
    public function checkViewcounterConfigs(ViewcounterConfig $viewcounterConfig)
    {
        $this->checkViewIntervalNode($viewcounterConfig);
        $this->checkStatsNode($viewcounterConfig);

        return true;
    }

    /**
     * Checks the viewInterval node.
     *
     * @param ViewcounterConfig $viewcounterConfig
     *
     * @return bool
     */
    public function checkViewIntervalNode(ViewcounterConfig $viewcounterConfig)
    {
        if (false == $viewcounterConfig->getViewIntervalName()) {
            throw new RuntimeException(vsprintf('You must set one of the following view interval to true: %s, %s, %s, %s, %s, %s.', TchoulomViewCounterBundle::SUPPORTED_INTERVAL));
        }

        return true;
    }

    /**
     * Checks the stats node.
     *
     * @param ViewcounterConfig $viewcounterConfig
     *
     * @return bool
     */
    public function checkStatsNode(ViewcounterConfig $viewcounterConfig)
    {
        $useStats = $viewcounterConfig->getUseStats();

        if (!is_bool($useStats)) {
            throw new RuntimeException(sprintf('The value "%s" must be a boolean.', $useStats));
        }

        return true;
    }
}