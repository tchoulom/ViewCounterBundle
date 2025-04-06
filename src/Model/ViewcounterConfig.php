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

namespace Tchoulom\ViewCounterBundle\Model;

/**
 * Class ViewcounterConfig
 */
class ViewcounterConfig
{
    /**
     * @var ViewcounterNodeConfig
     */
    protected $viewcounterNodeConfig;

    /**
     * @var StatisticsNodeConfig
     */
    protected $statisticsNodeConfig;

    /**
     * ViewcounterConfig constructor.
     *
     * @param ViewcounterNodeConfig $viewcounterNodeConfig
     * @param StatisticsNodeConfig $statisticsNodeConfig
     */
    public function __construct(ViewcounterNodeConfig $viewcounterNodeConfig, StatisticsNodeConfig $statisticsNodeConfig)
    {
        $this->viewcounterNodeConfig = $viewcounterNodeConfig;
        $this->statisticsNodeConfig = $statisticsNodeConfig;
    }

    /**
     * Gets the viewcounter node configuration.
     *
     * @return ViewcounterNodeConfig
     */
    public function getViewcounterNodeConfig()
    {
        return $this->viewcounterNodeConfig;
    }

    /**
     * Sets the viewcounter node configuration.
     *
     * @param ViewcounterNodeConfig $viewcounterNodeConfig
     *
     * @return ViewcounterConfig
     */
    public function setViewcounterNodeConfig($viewcounterNodeConfig)
    {
        $this->viewcounterNodeConfig = $viewcounterNodeConfig;

        return $this;
    }

    /**
     * Gets the statistics node configuration.
     *
     * @return StatisticsNodeConfig
     */
    public function getStatisticsNodeConfig()
    {
        return $this->statisticsNodeConfig;
    }

    /**
     * Sets the statistics node configuration.
     *
     * @param StatisticsNodeConfig $statisticsNodeConfig
     *
     * @return ViewcounterConfig
     */
    public function setStatisticsNodeConfig($statisticsNodeConfig)
    {
        $this->statisticsNodeConfig = $statisticsNodeConfig;

        return $this;
    }
}