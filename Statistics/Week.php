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
 * Class Week
 */
class Week
{
    protected $weekNumber;
    protected $total = 0;
    protected $monday;
    protected $tuesday;
    protected $wednesday;
    protected $thursday;
    protected $friday;
    protected $saturday;
    protected $sunday;

    /**
     * Week constructor.
     *
     * @param $total
     */
    public function __construct($total)
    {
        $this->weekNumber = Date::getNowWeek();
        $this->total = $total;
    }


    /**
     * Gets the number of week.
     *
     * @return int
     */
    public function getWeekNumber()
    {
        return $this->weekNumber;
    }

    /**
     * Sets the number of week.
     *
     * @param $weekNumber
     *
     * @return $this
     */
    public function setWeekNumber($weekNumber)
    {
        $this->weekNumber = $weekNumber;

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
     * Gets the monday day.
     *
     * @return Day
     */
    public function getMonday()
    {
        return $this->monday;
    }

    /**
     * Sets the monday day.
     *
     * @param Day $monday
     *
     * @return $this
     */
    public function setMonday(Day $monday)
    {
        $this->monday = $monday;

        return $this;
    }

    /**
     * Gets the tuesday day.
     *
     * @return Day
     */
    public function getTuesday()
    {
        return $this->tuesday;
    }

    /**
     * Sets the tuesday day.
     *
     * @param Day $tuesday
     *
     * @return $this
     */
    public function setTuesday(Day $tuesday)
    {
        $this->tuesday = $tuesday;

        return $this;
    }

    /**
     * Gets the wdnesday day.
     *
     * @return Day
     */
    public function getWednesday()
    {
        return $this->wednesday;
    }

    /**
     * Sets the wdnesday day.
     *
     * @param Day $wednesday
     *
     * @return $this
     */
    public function setWednesday(Day $wednesday)
    {
        $this->wednesday = $wednesday;

        return $this;
    }

    /**
     * Gets the thursday day.
     *
     * @return Day
     */
    public function getThursday()
    {
        return $this->thursday;
    }

    /**
     * Sets the thursday day.
     *
     * @param Day $thursday
     *
     * @return $this
     */
    public function setThursday(Day $thursday)
    {
        $this->thursday = $thursday;

        return $this;
    }

    /**
     * Gets the friday day.
     *
     * @return Day
     */
    public function getFriday()
    {
        return $this->friday;
    }

    /**
     * Sets the friday day.
     *
     * @param Day $friday
     *
     * @return $this
     */
    public function setFriday(Day $friday)
    {
        $this->friday = $friday;

        return $this;
    }

    /**
     * Gets the saturday day.
     *
     * @return Day
     */
    public function getSaturday()
    {
        return $this->saturday;
    }

    /**
     * Sets the saturday day.
     *
     * @param Day $saturday
     *
     * @return $this
     */
    public function setSaturday(Day $saturday)
    {
        $this->saturday = $saturday;

        return $this;
    }

    /**
     * Gets the sunday day.
     *
     * @return Day
     */
    public function getSunday()
    {
        return $this->sunday;
    }

    /**
     * Sets the sunday day.
     *
     * @param Day $sunday
     *
     * @return $this
     */
    public function setSunday(Day $sunday)
    {
        $this->sunday = $sunday;

        return $this;
    }

    /**
     * Builds the day.
     *
     * @return $this
     */
    public function buildDay()
    {
        $this->total++;
        $day = $this->getDay();
        $dayName = strtolower($day->getName());
        $this->$dayName = $day->build();

        return $this;
    }

    /**
     * Gets the day.
     *
     * @return Day
     */
    public function getDay()
    {
        $dayName = Date::getDayName();
        $getDay = 'get' . ucfirst($dayName);
        $day = $this->$getDay();

        if (null == $day) {
            $day = new Day($dayName, 0);
        }

        return $day;
    }
}