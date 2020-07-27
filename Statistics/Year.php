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

use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class Year
 */
class Year
{
    /**
     * The year number.
     *
     * @var int
     */
    protected $yearNumber;

    /**
     * The total.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * The months.
     *
     * @var Month[]
     */
    protected $months = [];

    /**
     * Year constructor.
     */
    public function __construct()
    {
        $this->yearNumber = Date::getNowYear();
    }

    /**
     * Gets the number of year.
     *
     * @return int
     */
    public function getYearNumber(): int
    {
        return $this->yearNumber;
    }

    /**
     * Sets the number of year.
     *
     * @param int $yearNumber
     *
     * @return self
     */
    public function setYearNumber(int $yearNumber): self
    {
        $this->yearNumber = $yearNumber;

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
     * Gets the months.
     *
     * @return Month[]
     */
    public function getMonths(): array
    {
        return $this->months;
    }

    /**
     * Builds the month.
     *
     * @return self
     */
    public function buildMonth(): self
    {
        $this->total++;
        $monthNumber = Date::getNowMonth();

        if (isset($this->months[$monthNumber])) {
            $month = $this->months[$monthNumber];
        } else {
            $month = new Month();
        }

        $this->months[$monthNumber] = $month->buildWeek();

        return $this;
    }
}
