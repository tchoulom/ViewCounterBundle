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

namespace Tchoulom\ViewCounterBundle\Util;

/**
 * Class Date
 */
class Date
{
    const TIME_ZONE = 'Europe/Paris';

    /**
     * Gets now year.
     *
     * @return int
     */
    public static function getNowYear()
    {
        return (int)date('Y');
    }

    /**
     * Gets now month.
     *
     * @return int
     */
    public static function getNowMonth()
    {
        return (int)date('m');
    }

    /**
     * Gets now week.
     *
     * @return int
     */
    public static function getNowWeek()
    {
        return (int)date('W');
    }

    /**
     * Gets day name.
     *
     * @return false|string
     */
    public static function getDayName()
    {
        return date('l');
    }

    /**
     * Gets the hour.
     *
     * @return false|string
     */
    public static function getHour()
    {
        return date('H');
    }

    /**
     * Gets the minute.
     *
     * @return false|string
     */
    public static function getMinute()
    {
        return date('i');
    }

    /**
     * Gets the second.
     *
     * @return false|string
     */
    public static function getSecond()
    {
        return date('s');
    }

    /**
     * Gets the full hour.
     *
     * @return false|string
     */
    public static function getFullHour()
    {
        return date('H:i:s');
    }

    /**
     * Gets the week days name.
     *
     * @return array
     */
    public static function getWeekDaysName()
    {
        return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    }

    /**
     * Gets the now DateTime.
     *
     * @param null $timeZone
     *
     * @return \DateTime
     */
    public static function getNowDate($timeZone = null)
    {
        return new \DateTime('now', self::getDateTimeZone($timeZone));
    }

    /**
     * Gets the DateTimeZone.
     *
     * @param null $timeZone
     *
     * @return \DateTimeZone
     */
    public static function getDateTimeZone($timeZone = null)
    {
        $timeZone = (null == $timeZone) ? self::TIME_ZONE : $timeZone;
        $dateTimeZone = new \DateTimeZone($timeZone);

        return $dateTimeZone;
    }

    /**
     * Gets the next year.
     *
     * @param \DateTimeInterface $date
     *
     * @return mixed
     */
    public static function getNextYear(\DateTimeInterface $date)
    {
        // Sets Date and Minutes...
        $dateYear = intval($date->format("Y"));

        // Sets to first day of month
        $date->setDate($dateYear, 1, 1);
        $date->setTime(0, 0, 0);

        // Next Year
        $nextYear = $date->add(new \DateInterval("P1Y"));

        return $nextYear;
    }

    /**
     * Gets the next month.
     *
     * @param \DateTimeInterface $date
     *
     * @return mixed
     */
    public static function getNextMonth(\DateTimeInterface $date)
    {
        // Sets Date and Minutes...
        $dateYear = intval($date->format("Y"));
        $dateMonth = intval($date->format("m"));

        // Sets to first day of month
        $date->setDate($dateYear, $dateMonth, 1);
        $date->setTime(0, 0, 0);

        // Next Month
        $nextMonth = $date->add(new \DateInterval("P1M"));

        return $nextMonth;
    }

    /**
     * Gets the next week.
     *
     * @param \DateTimeInterface $date
     *
     * @return mixed
     */
    public static function getNextWeek(\DateTimeInterface $date)
    {
        // Sets to first day of week
        $date->setISODate($date->format("Y"), $date->format("W"), 1);

        // Next Week
        $nextWeek = $date->add(new \DateInterval("P7D"));

        return $nextWeek;
    }

    /**
     * Gets the next day.
     *
     * @param \DateTimeInterface $date
     *
     * @return mixed
     */
    public static function getNextDay(\DateTimeInterface $date)
    {
        $nextDay = $date->add(new \DateInterval('P1D'));

        // Sets the next day at midnight
        $nextDay->setTime(0, 0, 0);

        return $nextDay;
    }

    /**
     * Gets the next hour.
     *
     * @param \DateTimeInterface $date
     *
     * @return mixed
     */
    public static function getNextHour(\DateTimeInterface $date)
    {
        // Sets Minutes and Second to zero
        $dateHour = intval($date->format('H'));
        $date->setTime($dateHour, 0, 0);

        $nextHour = $date->add(new \DateInterval('PT1H'));

        return $nextHour;
    }

    /**
     * Gets the next minute.
     *
     * @param \DateTimeInterface $date
     *
     * @return mixed
     */
    public static function getNextMinute(\DateTimeInterface $date)
    {
        // Sets Second to zero
        $dateHour = intval($date->format('H'));
        $dateMinute = intval($date->format('i'));
        $date->setTime($dateHour, $dateMinute, 0);

        $nextMinute = $date->add(new \DateInterval('PT1M'));

        return $nextMinute;
    }

    /**
     * Gets the next second.
     *
     * @param \DateTimeInterface $date
     *
     * @return mixed
     */
    public static function getNextSecond(\DateTimeInterface $date)
    {
        $nextSecond = $date->add(new \DateInterval('PT1S'));

        return $nextSecond;
    }

    /**
     * Builds time range.
     *
     * @param int $start
     * @param int $end
     *
     * @return array
     */
    public static function buildTimeRange($start = 0, $end = 23)
    {
        $range = [];

        foreach (range($start, $end) as $i) {
            $i = (string)$i;
            if (strlen($i) < 2) {
                $i = '0' . $i;
            }

            $range[] = $i;
        }

        return $range;
    }
}
