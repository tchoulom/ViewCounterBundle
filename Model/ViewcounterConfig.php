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
    protected $viewIntervalNode;
    protected $statsNode;
    protected $viewIntervalName;
    protected $useStats;
    protected $statsExtension;

    /**
     * ViewcounterConfig constructor.
     *
     * @param array $viewIntervalNode
     * @param array $statsNode
     */
    public function __construct(array $viewIntervalNode, array $statsNode)
    {
        $this->viewIntervalNode = $viewIntervalNode;
        $this->statsNode = $statsNode;

        $this->setConfiguration($this->viewIntervalNode, $this->statsNode);
    }

    /**
     * Gets the view interval node.
     *
     * @return array
     */
    public function getViewIntervalNode()
    {
        return $this->viewIntervalNode;
    }

    /**
     * Sets the view interval node.
     *
     * @param array $viewIntervalNode
     *
     * @return $this
     */
    public function setViewIntervalNode(array $viewIntervalNode)
    {
        $this->viewIntervalNode = $viewIntervalNode;

        return $this;
    }

    /**
     * Gets the stats node.
     *
     * @return array
     */
    public function getStatsNode()
    {
        return $this->statsNode;
    }

    /**
     * Sets the stats node.
     *
     * @param array $statsNode
     *
     * @return $this
     */
    public function setStatsNode(array $statsNode)
    {
        $this->statsNode = $statsNode;

        return $this;
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

    /**
     * Sets the configuration.
     *
     * @param array $viewIntervalNode
     * @param array $statsNode
     *
     * @return $this
     */
    public function setConfiguration(array $viewIntervalNode, array $statsNode)
    {
        $viewIntervalName = array_search(true, $viewIntervalNode, true);
        $this->viewIntervalName = $viewIntervalName;
        $this->useStats = $statsNode['use_stats'];
        $this->statsExtension = $statsNode['stats_extension'];

        return $this;
    }
}