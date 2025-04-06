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

namespace Tchoulom\ViewCounterBundle\Counter;

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class ViewCounter
 */
class ViewCounter extends AbstractViewCounter
{
    /**
     * Determines whether the view is new.
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is new view ?
     */
    public function isNewView(ViewCounterInterface $viewCounter): bool
    {
        if (null == $viewCounter->getViewDate()) {
            return true;
        }

        $viewStrategy = $this->getViewStrategy();

        if (self::ON_REFRESH === $viewStrategy) {
            return true;
        }

        if (self::UNIQUE_VIEW === $viewStrategy) {
            return false;
        }

        if (self::DAILY_VIEW === $viewStrategy) {
            return $this->isNewDailyView($viewCounter);
        }

        if (self::HOURLY_VIEW === $viewStrategy) {
            return $this->isNewHourlyView($viewCounter);
        }

        if (self::WEEKLY_VIEW === $viewStrategy) {
            return $this->isNewWeeklyView($viewCounter);
        }

        if (self::MONTHLY_VIEW === $viewStrategy) {
            return $this->isNewMonthlyView($viewCounter);
        }

        if (self::YEARLY_VIEW === $viewStrategy) {
            return $this->isNewYearlyView($viewCounter);
        }

        if (self::VIEW_PER_MINUTE === $viewStrategy) {
            return $this->isViewPerMinute($viewCounter);
        }

        if (self::VIEW_PER_SECOND === $viewStrategy) {
            return $this->isViewPerSecond($viewCounter);
        }

        return false;
    }

    /**
     * Checks whether this is a new daily view.
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is new daily view ?
     */
    protected function isNewDailyView(ViewCounterInterface $viewCounter): bool
    {
        // Next day
        $viewDate = clone $viewCounter->getViewDate();
        $nextDay = Date::getNextDay($viewDate);
        $nextDayTimestamp = strtotime($nextDay->format('Y-m-d H:i:s'));

        return Date::time() >= $nextDayTimestamp;
    }

    /**
     * Checks whether this is a new hourly view.
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is new hourly view ?
     */
    protected function isNewHourlyView(ViewCounterInterface $viewCounter): bool
    {
        // Next hour
        $viewDate = clone $viewCounter->getViewDate();
        $nextHour = Date::getNextHour($viewDate);
        $nextHourTimestamp = strtotime($nextHour->format('Y-m-d H:i:s'));

        return Date::time() >= $nextHourTimestamp;
    }

    /**
     * Checks whether this is a new weekly view.
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is new weekly view ?
     */
    protected function isNewWeeklyView(ViewCounterInterface $viewCounter): bool
    {
        // Next week
        $viewDate = clone $viewCounter->getViewDate();
        $nextWeek = Date::getNextWeek($viewDate);
        $nextWeekTimestamp = strtotime($nextWeek->format('Y-m-d H:i:s'));

        return Date::time() >= $nextWeekTimestamp;
    }

    /**
     * Checks whether this is a new monthly view.
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is new monthly view ?
     */
    protected function isNewMonthlyView(ViewCounterInterface $viewCounter): bool
    {
        // Next month
        $viewDate = clone $viewCounter->getViewDate();
        $nextMonth = Date::getNextMonth($viewDate);
        $nextMonthTimestamp = strtotime($nextMonth->format('Y-m-d H:i:s'));

        return Date::time() >= $nextMonthTimestamp;
    }

    /**
     * Checks whether this is a new yearly view.
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is new yearly view ?
     */
    protected function isNewYearlyView(ViewCounterInterface $viewCounter): bool
    {
        // Next month
        $viewDate = clone $viewCounter->getViewDate();
        $nextYear = Date::getNextYear($viewDate);
        $nextYearTimestamp = strtotime($nextYear->format('Y-m-d H:i:s'));

        return Date::time() >= $nextYearTimestamp;
    }

    /**
     * Checks whether this is a new "view per minute".
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is view per minute ?
     */
    protected function isViewPerMinute(ViewCounterInterface $viewCounter): bool
    {
        // Next minute
        $viewDate = clone $viewCounter->getViewDate();
        $nextMinute = Date::getNextMinute($viewDate);
        $nextMinuteTimestamp = strtotime($nextMinute->format('Y-m-d H:i:s'));

        return Date::time() >= $nextMinuteTimestamp;
    }

    /**
     * Checks whether this is a new "view per second".
     *
     * @param ViewCounterInterface $viewCounter The Viewcounter.
     *
     * @return bool Is view per second ?
     */
    protected function isViewPerSecond(ViewCounterInterface $viewCounter): bool
    {
        // Next second
        $viewDate = clone $viewCounter->getViewDate();
        $nextSecond = Date::getNextSecond($viewDate);
        $nextSecondTimestamp = strtotime($nextSecond->format('Y-m-d H:i:s'));

        return Date::time() >= $nextSecondTimestamp;
    }
}
