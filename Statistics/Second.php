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

namespace Tchoulom\ViewCounterBundle\Statistics;

/**
 * Class Second
 */
class Second
{
    /**
     * The second name.
     *
     * @var string
     */
    protected $name;

    /**
     * The total.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Second constructor.
     *
     * @param string $name
     * @param int $total
     */
    public function __construct(string $name, int $total)
    {
        $this->name = $name;
        $this->total = $total;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the total.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Sets the total.
     *
     * @param int $total
     *
     * @return self
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Builds the minute.
     *
     * @return self
     */
    public function build(): self
    {
        $this->total++;

        return $this;
    }
}
