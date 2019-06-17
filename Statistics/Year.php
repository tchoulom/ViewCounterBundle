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
    protected $yearNumber;
    protected $total = 0;
    protected $months = [];

    /**
     * Year constructor.
     *
     * @param array $months
     * @param $total
     */
    public function __construct(array $months, $total)
    {
        $this->yearNumber = Date::getNowYear();
        $this->months = $months;
        $this->total = $total;
    }


    /**
     * Gets the number of year.
     *
     * @return int
     */
    public function getYearNumber()
    {
        return $this->yearNumber;
    }

    /**
     * Sets the number of year.
     *
     * @param $yearNumber
     *
     * @return $this
     */
    public function setYearNumber($yearNumber)
    {
        $this->yearNumber = $yearNumber;

        return $this;
    }

    /**
     * Gets the total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Sets the total.
     *
     * @param $total
     *
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Gets the months.
     *
     * @return array
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * Sets the months.
     *
     * @param array $months
     *
     * @return $this
     */
    public function setMonths(array $months)
    {
        $this->months = $months;

        return $this;
    }

    /**
     * Builds the month.
     *
     * @return $this
     */
    public function buildMonth()
    {
        $this->total++;
        $monthNumber = Date::getNowMonth();

        if (isset($this->months[$monthNumber])) {
            $month = $this->months[$monthNumber];
        } else {
            $month = new Month([], 0);
        }

        $this->months[$monthNumber] = $month->buildWeek();

        return $this;
    }
}