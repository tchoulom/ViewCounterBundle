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

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class Week
 */
class Week
{
    /**
     * The week number.
     *
     * @var int
     */
    protected $weekNumber;

    /**
     * The total.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Monday.
     *
     * @var Day|null
     */
    protected $monday;

    /**
     * Tuesday.
     *
     * @var Day|null
     */
    protected $tuesday;

    /**
     * Wednesday.
     *
     * @var Day|null
     */
    protected $wednesday;

    /**
     * Thursday.
     *
     * @var Day|null
     */
    protected $thursday;

    /**
     * Friday.
     *
     * @var Day|null
     */
    protected $friday;

    /**
     * Saturday.
     *
     * @var Day|null
     */
    protected $saturday;

    /**
     * Sunday.
     *
     * @var Day|null
     */
    protected $sunday;

    /**
     * Week constructor.
     */
    public function __construct()
    {
        $this->weekNumber = Date::getNowWeek();
    }


    /**
     * Gets the number of week.
     *
     * @return int
     */
    public function getWeekNumber(): int
    {
        return $this->weekNumber;
    }

    /**
     * Sets the number of week.
     *
     * @param int $weekNumber
     *
     * @return self
     */
    public function setWeekNumber(int $weekNumber): self
    {
        $this->weekNumber = $weekNumber;

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
     * Gets the monday day.
     *
     * @return Day|null
     */
    public function getMonday(): ?Day
    {
        return $this->monday;
    }

    /**
     * Sets the monday day.
     *
     * @param Day $monday
     *
     * @return self
     */
    public function setMonday(Day $monday): self
    {
        $this->monday = $monday;

        return $this;
    }

    /**
     * Gets the tuesday day.
     *
     * @return Day|null
     */
    public function getTuesday(): ?Day
    {
        return $this->tuesday;
    }

    /**
     * Sets the tuesday day.
     *
     * @param Day $tuesday
     *
     * @return self
     */
    public function setTuesday(Day $tuesday): self
    {
        $this->tuesday = $tuesday;

        return $this;
    }

    /**
     * Gets the wdnesday day.
     *
     * @return Day|null
     */
    public function getWednesday(): ?Day
    {
        return $this->wednesday;
    }

    /**
     * Sets the wdnesday day.
     *
     * @param Day $wednesday
     *
     * @return self
     */
    public function setWednesday(Day $wednesday): self
    {
        $this->wednesday = $wednesday;

        return $this;
    }

    /**
     * Gets the thursday day.
     *
     * @return Day|null
     */
    public function getThursday(): ?Day
    {
        return $this->thursday;
    }

    /**
     * Sets the thursday day.
     *
     * @param Day $thursday
     *
     * @return self
     */
    public function setThursday(Day $thursday): self
    {
        $this->thursday = $thursday;

        return $this;
    }

    /**
     * Gets the friday day.
     *
     * @return Day|null
     */
    public function getFriday(): ?Day
    {
        return $this->friday;
    }

    /**
     * Sets the friday day.
     *
     * @param Day $friday
     *
     * @return self
     */
    public function setFriday(Day $friday): self
    {
        $this->friday = $friday;

        return $this;
    }

    /**
     * Gets the saturday day.
     *
     * @return Day|null
     */
    public function getSaturday(): ?Day
    {
        return $this->saturday;
    }

    /**
     * Sets the saturday day.
     *
     * @param Day $saturday
     *
     * @return self
     */
    public function setSaturday(Day $saturday): self
    {
        $this->saturday = $saturday;

        return $this;
    }

    /**
     * Gets the sunday day.
     *
     * @return Day|null
     */
    public function getSunday(): ?Day
    {
        return $this->sunday;
    }

    /**
     * Sets the sunday day.
     *
     * @param Day $sunday
     *
     * @return self
     */
    public function setSunday(Day $sunday): self
    {
        $this->sunday = $sunday;

        return $this;
    }

    /**
     * Builds the day.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return self
     */
    public function buildDay(ViewCounterInterface $viewcounter): self
    {
        $this->total++;
        $dayName = $viewcounter->getViewDate()->format('l');
        $day = $this->getDay($dayName);
        $dayName = strtolower($day->getName());

        $this->$dayName = $day->build($viewcounter);

        return $this;
    }

    /**
     * Gets the day.
     *
     * @param string|null $dayName
     *
     * @return Day
     */
    public function getDay(?string $dayName = null): Day
    {
        if (null == $dayName) {
            $dayName = Date::getDayName();
        }

        $getDay = 'get' . ucfirst($dayName);
        $day = $this->$getDay();

        if (!$day instanceof Day) {
            $day = new Day($dayName, 0);
        }

        return $day;
    }
}
