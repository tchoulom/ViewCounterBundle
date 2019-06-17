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

namespace Tchoulom\ViewCounterBundle\Model;

/**
 * Class ViewcounterConfig
 */
class ViewcounterConfig
{
    protected $viewIntervalName;
    protected $useStats;
    protected $statsExtension;

    /**
     * ViewcounterConfig constructor.
     *
     * @param $viewIntervalName
     * @param $useStats
     * @param $statsExtension
     */
    public function __construct($viewIntervalName, $useStats, $statsExtension)
    {
        $this->viewIntervalName = $viewIntervalName;
        $this->useStats = $useStats;
        $this->statsExtension = $statsExtension;
    }

    /**
     * Gets the view interval name.
     *
     * @return mixed
     */
    public function getViewIntervalName()
    {
        return $this->viewIntervalName;
    }

    /**
     * Sets the view interval name.
     *
     * @param mixed $viewIntervalName
     *
     * @return ViewcounterConfig
     */
    public function setViewIntervalName($viewIntervalName)
    {
        $this->viewIntervalName = $viewIntervalName;

        return $this;
    }

    /**
     * Gets the use_stats boolean value.
     *
     * @return boolean
     */
    public function getUseStats()
    {
        return $this->useStats;
    }

    /**
     * Sets the use_stats value.
     *
     * @param boolean $useStats
     *
     * @return ViewcounterConfig
     */
    public function setUseStats($useStats)
    {
        $this->useStats = $useStats;

        return $this;
    }

    /**
     * Gets the stats_extension value
     *
     * @return mixed
     */
    public function getStatsExtension()
    {
        return $this->statsExtension;
    }

    /**
     * Sets the stats_extension value
     *
     * @param mixed $statsExtension
     *
     * @return ViewcounterConfig
     */
    public function setStatsExtension($statsExtension)
    {
        $this->statsExtension = $statsExtension;

        return $this;
    }
}