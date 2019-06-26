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
    protected $viewStrategy;
    protected $useStats;
    protected $statsFileName;
    protected $statsFileExtension;

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
     * Gets the view strategy.
     *
     * @return mixed
     */
    public function getViewStrategy()
    {
        return $this->viewStrategy;
    }

    /**
     * Sets the view strategy.
     *
     * @param mixed $viewStrategy
     *
     * @return ViewcounterConfig
     */
    public function setViewStrategy($viewStrategy)
    {
        $this->viewStrategy = $viewStrategy;

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
     * Gets the stats file extension.
     *
     * @return mixed
     */
    public function getStatsFileExtension()
    {
        return $this->statsFileExtension;
    }

    /**
     * Sets the stats file extension.
     *
     * @param mixed $statsFileExtension
     *
     * @return ViewcounterConfig
     */
    public function setStatsFileExtension($statsFileExtension)
    {
        $this->statsFileExtension = $statsFileExtension;

        return $this;
    }

    /**
     * Gets the stats file name.
     *
     * @return mixed
     */
    public function getStatsFileName()
    {
        return $this->statsFileName;
    }

    /**
     * Sets the stats file name.
     *
     * @param mixed $statsFileName
     *
     * @return ViewcounterConfig
     */
    public function setStatsFileName($statsFileName)
    {
        $this->statsFileName = $statsFileName;

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
        $this->viewStrategy = $viewIntervalNode['view_strategy'];
        $this->useStats = $statsNode['use_stats'];
        $this->statsFileName = $statsNode['stats_file_name'];
        $this->statsFileExtension = $statsNode['stats_file_extension'];

        return $this;
    }
}