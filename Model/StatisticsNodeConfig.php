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
 * Class StatisticsNodeConfig
 */
class StatisticsNodeConfig
{
    /**
     * @var bool Is statistics enabled?.
     */
    protected $isStatsEnabled;

    /**
     * @var ?string The name of the statistics file.
     */
    protected $statsFileName;

    /**
     * @var ?string The extension of the statistics file.
     */
    protected $statsFileExtension;

    /**
     * StatisticsNodeConfig constructor.
     *
     * @param array $statsNode
     */
    public function __construct(array $statsNode)
    {
        $this->isStatsEnabled = $statsNode['enabled'];
        $this->statsFileName = $statsNode['stats_file_name'];
        $this->statsFileExtension = $statsNode['stats_file_extension'];
    }

    /**
     * Gets the enabled boolean value.
     *
     * @return bool Is stats enabled ?
     */
    public function isStatsEnabled(): bool
    {
        return $this->isStatsEnabled;
    }

    /**
     * Sets the enabled value.
     *
     * @param bool $isStatsEnabled
     *
     * @return self
     */
    public function setIsStatsEnabled(bool $isStatsEnabled): self
    {
        $this->isStatsEnabled = $isStatsEnabled;

        return $this;
    }

    /**
     * Gets the stats file name.
     *
     * @return string|null
     */
    public function getStatsFileName(): ?string
    {
        return $this->statsFileName;
    }

    /**
     * Sets the stats file name.
     *
     * @param string $statsFileName
     *
     * @return self
     */
    public function setStatsFileName(string $statsFileName): self
    {
        $this->statsFileName = $statsFileName;

        return $this;
    }

    /**
     * Gets the stats file extension.
     *
     * @return string|null
     */
    public function getStatsFileExtension(): ?string
    {
        return $this->statsFileExtension;
    }

    /**
     * Sets the stats file extension.
     *
     * @param string $statsFileExtension
     *
     * @return self
     */
    public function setStatsFileExtension(string $statsFileExtension): self
    {
        $this->statsFileExtension = $statsFileExtension;

        return $this;
    }
}
