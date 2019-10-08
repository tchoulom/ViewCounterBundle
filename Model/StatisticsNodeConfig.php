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
 * Class StatisticsNodeConfig
 */
class StatisticsNodeConfig
{
    /**
     * @var mixed Allows to indicate if you want to use statistics.
     */
    protected $useStats;

    /**
     * @var mixed The name of the statistics file.
     */
    protected $statsFileName;

    /**
     * @var mixed The extension of the statistics file.
     */
    protected $statsFileExtension;

    /**
     * StatisticsNodeConfig constructor.
     *
     * @param array $statsNode
     */
    public function __construct(array $statsNode)
    {
        $this->useStats = $statsNode['use_stats'];
        $this->statsFileName = $statsNode['stats_file_name'];
        $this->statsFileExtension = $statsNode['stats_file_extension'];
    }

    /**
     * Gets the use_stats boolean value.
     *
     * @return boolean
     */
    public function canUseStats()
    {
        return $this->useStats;
    }

    /**
     * Sets the use_stats value.
     *
     * @param $useStats
     *
     * @return $this
     */
    public function setUseStats($useStats)
    {
        $this->useStats = $useStats;

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
     * @param $statsFileName
     *
     * @return $this
     */
    public function setStatsFileName($statsFileName)
    {
        $this->statsFileName = $statsFileName;

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
     * @param $statsFileExtension
     *
     * @return $this
     */
    public function setStatsFileExtension($statsFileExtension)
    {
        $this->statsFileExtension = $statsFileExtension;

        return $this;
    }
}