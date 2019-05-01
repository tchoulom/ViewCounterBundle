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

namespace Tchoulom\ViewCounterBundle\Counter;

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;

/**
 * Class ViewCounter
 */
class ViewCounter extends AbstractViewCounter
{
    /**
     * Determines whether the view is new.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return bool
     */
    public function isNewView(ViewCounterInterface $viewCounter)
    {
        if (null == $viewCounter->getViewDate()) {
            return true;
        }

        $viewIntervalName = $this->getViewIntervalName();

        if (self::INCREMENT_EACH_VIEW === $viewIntervalName) {
            return true;
        }

        if (self::UNIQUE_VIEW === $viewIntervalName) {
            return false;
        }

        if (self::DAILY_VIEW === $viewIntervalName) {
            return $this->isNewDailyView($viewCounter);
        }

        if (self::HOURLY_VIEW === $viewIntervalName) {
            return $this->isNewHourlyView($viewCounter);
        }

        if (self::WEEKLY_VIEW === $viewIntervalName) {
            return $this->isNewWeeklyView($viewCounter);
        }

        if (self::MONTHLY_VIEW === $viewIntervalName) {
            return $this->isNewMonthlyView($viewCounter);
        }

        return false;
    }

    /**
     * Checks whether this is a new daily view.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return bool
     */
    protected function isNewDailyView(ViewCounterInterface $viewCounter)
    {
        // Next day
        $viewDate = clone $viewCounter->getViewDate();
        $nextDay = $this->getNextDay($viewDate);
        $nextDayTimestamp = strtotime($nextDay->format('Y-m-d H:i:s'));

        // Current Timestamp
        $currentTimestamp = time();

        return $currentTimestamp >= $nextDayTimestamp;
    }

    /**
     * Checks whether this is a new hourly view.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return bool
     */
    public function isNewHourlyView(ViewCounterInterface $viewCounter)
    {
        // Next hour
        $viewDate = clone $viewCounter->getViewDate();
        $nextHour = $this->getNextHour($viewDate);
        $nextHourTimestamp = strtotime($nextHour->format('Y-m-d H:i:s'));

        // Current Timestamp
        $currentTimestamp = time();

        return $currentTimestamp >= $nextHourTimestamp;
    }

    /**
     * Checks whether this is a new weekly view.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return bool
     */
    public function isNewWeeklyView(ViewCounterInterface $viewCounter)
    {
        // Next week
        $viewDate = clone $viewCounter->getViewDate();
        $nextWeek = $this->getNextWeek($viewDate);
        $nextWeekTimestamp = strtotime($nextWeek->format('Y-m-d H:i:s'));

        // Current Timestamp
        $currentTimestamp = time();

        return $currentTimestamp >= $nextWeekTimestamp;
    }

    /**
     * Checks whether this is a new monthly view.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return bool
     */
    public function isNewMonthlyView(ViewCounterInterface $viewCounter)
    {
        // Next month
        $viewDate = clone $viewCounter->getViewDate();
        $nextMonth = $this->getNextMonth($viewDate);
        $nextMonthTimestamp = strtotime($nextMonth->format('Y-m-d H:i:s'));

        // Current Timestamp
        $currentTimestamp = time();

        return $currentTimestamp >= $nextMonthTimestamp;
    }

    /**
     * Gets the next day.
     *
     * @param \DateTimeInterface $viewDate
     *
     * @return static
     */
    public function getNextDay(\DateTimeInterface $viewDate)
    {
        $nextDay = $viewDate->add(new \DateInterval('P1D'));

        // Sets the next day at midnight
        $nextDay->setTime(0, 0, 0);

        return $nextDay;
    }

    /**
     * Gets the next hour.
     *
     * @param \DateTimeInterface $viewDate
     *
     * @return static
     */
    public function getNextHour(\DateTimeInterface $viewDate)
    {
        // Sets Minutes and Second to zero
        $viewDateHour = intval($viewDate->format('H'));
        $viewDate->setTime($viewDateHour, 0, 0);

        $nextHour = $viewDate->add(new \DateInterval('PT1H'));

        return $nextHour;
    }

    /**
     * Gets the next week.
     *
     * @param \DateTimeInterface $viewDate
     *
     * @return static
     */
    public function getNextWeek(\DateTimeInterface $viewDate)
    {
        // Sets to first day of week
        $viewDate->setISODate($viewDate->format("Y"), $viewDate->format("W"), 1);

        // Next Week
        $nextWeek = $viewDate->add(new \DateInterval("P7D"));

        return $nextWeek;
    }

    /**
     * Gets the next month.
     *
     * @param \DateTimeInterface $viewDate
     *
     * @return static
     */
    public function getNextMonth(\DateTimeInterface $viewDate)
    {
        // Sets Date and Minutes...
        $viewDateYear = intval($viewDate->format("Y"));
        $viewDateMonth = intval($viewDate->format("m"));

        // Sets to first day of month
        $viewDate->setDate($viewDateYear, $viewDateMonth, 1);
        $viewDate->setTime(0, 0, 0);

        // Next Month
        $nextMonth = $viewDate->add(new \DateInterval("P1M"));

        return $nextMonth;
    }
}