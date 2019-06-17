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
 * Class Month
 */
class Month
{
    protected $monthNumber;
    protected $total;
    protected $weeks = [];

    /**
     * Month constructor.
     *
     * @param array $weeks
     * @param $total
     */
    public function __construct(array $weeks, $total)
    {
        $this->monthNumber = Date::getNowMonth();
        $this->weeks = $weeks;
        $this->total = $total;
    }


    /**
     * Gets the number of month.
     *
     * @return int
     */
    public function getMonthNumber()
    {
        return $this->monthNumber;
    }

    /**
     * Sets the number of month.
     *
     * @param $monthNumber
     *
     * @return $this
     */
    public function setMonthNumber($monthNumber)
    {
        $this->monthNumber = $monthNumber;

        return $this;
    }

    /**
     * Gets the total.
     *
     * @return integer
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
     * Gets the weeks.
     *
     * @return array
     */
    public function getWeeks()
    {
        return $this->weeks;
    }

    /**
     * Sets the weeks.
     *
     * @param array $weeks
     *
     * @return $this
     */
    public function setWeeks(array $weeks)
    {
        $this->weeks = $weeks;

        return $this;
    }

    /**
     * Builds the week.
     *
     * @return $this
     */
    public function buildWeek()
    {
        $this->total++;
        $weekNumber = Date::getNowWeek();

        if (isset($this->weeks[$weekNumber])) {
            $week = $this->weeks[$weekNumber];
        } else {
            $week = new Week(0);
        }

        $this->weeks[$weekNumber] = $week->buildDay();

        return $this;
    }
}