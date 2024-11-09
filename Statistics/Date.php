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

namespace Tchoulom\ViewCounterBundle\Statistics;

/**
 * Class Date
 */
class Date
{
    /**
     * The total.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * The Full Date.
     *
     * @var \DateTimeInterface
     */
    protected $fullDate;

    /**
     * Date constructor.
     *
     * @param int $total
     * @param $fullDate
     */
    public function __construct(int $total, $fullDate)
    {
        $this->total = $total;
        $this->fullDate = $fullDate;
    }

    /**
     * Gets the total.
     *
     * @return int The total
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Sets the total.
     *
     * @param int $total The total
     *
     * @return self
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Gets the full date.
     *
     * @return \DateTimeInterface The DateTimeInterface
     */
    public function getFullDate(): \DateTimeInterface
    {
        return $this->fullDate;
    }

    /**
     * Sets the full date.
     *
     * @param \DateTimeInterface $fullDate The DateTimeInterface
     *
     * @return self
     */
    public function setFullDate(\DateTimeInterface $fullDate): self
    {
        $this->fullDate = $fullDate;

        return $this;
    }

    /**
     * Builds the Date.
     *
     * @return self
     */
    public function build(): self
    {
        $this->total++;

        return $this;
    }
}
