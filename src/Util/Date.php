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

namespace Tchoulom\ViewCounterBundle\Util;

/**
 * Class Date
 */
class Date
{
    /**
     * @var string TIME_ZONE The default timezone.
     */
    const TIME_ZONE = 'Europe/Paris';

    /**
     * Gets now year.
     *
     * @return int The now year.
     */
    public static function getNowYear(): int
    {
        return (int)date('Y');
    }

    /**
     * Gets now month.
     *
     * @return int The now month.
     */
    public static function getNowMonth(): int
    {
        return (int)date('m');
    }

    /**
     * Gets now week.
     *
     * @return int The now week.
     */
    public static function getNowWeek(): int
    {
        return (int)date('W');
    }

    /**
     * Gets day name.
     *
     * @return false|string The day name.
     */
    public static function getDayName()
    {
        return date('l');
    }

    /**
     * Gets the hour.
     *
     * @return false|string The hour.
     */
    public static function getHour()
    {
        return date('H');
    }

    /**
     * Gets the minute.
     *
     * @return false|string The minute.
     */
    public static function getMinute()
    {
        return date('i');
    }

    /**
     * Gets the second.
     *
     * @return false|string The second.
     */
    public static function getSecond()
    {
        return date('s');
    }

    /**
     * Gets the full hour.
     *
     * @return false|string The full hour.
     */
    public static function getFullHour()
    {
        return date('H:i:s');
    }

    /**
     * Gets the week days name.
     *
     * @return array The week Days name.
     */
    public static function getWeekDaysName(): array
    {
        return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    }

    /**
     * Gets the now DateTime.
     *
     * @param null $timeZone The timezone.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function getNowDate($timeZone = null): \DateTimeInterface
    {
        return new \DateTime('now', self::getDateTimeZone($timeZone));
    }

    /**
     * Gets the DateTimeZone.
     *
     * @param null $timeZone The timezone.
     *
     * @return \DateTimeZone The DateTimeZone.
     */
    public static function getDateTimeZone($timeZone = null): \DateTimeZone
    {
        $timeZone = (null == $timeZone) ? self::TIME_ZONE : $timeZone;

        return new \DateTimeZone($timeZone);
    }

    /**
     * Gets the next year.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getNextYear(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Date and Minutes...
        $dateYear = intval($date->format("Y"));

        // Sets to first day of month
        $date->setDate($dateYear, 1, 1);
        $date->setTime(0, 0, 0);

        // Next Year
        return $date->add(new \DateInterval("P1Y"));
    }

    /**
     * Gets the previous year.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getPreviousYear(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Date and Minutes...
        $dateYear = intval($date->format("Y"));

        // Sets to first day of month
        $date->setDate($dateYear, 1, 1);
        $date->setTime(0, 0, 0);

        // Next Year
        return $date->sub(new \DateInterval("P1Y"));
    }

    /**
     * Gets the next month.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getNextMonth(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Date and Minutes...
        $dateYear = intval($date->format("Y"));
        $dateMonth = intval($date->format("m"));

        // Sets to first day of month
        $date->setDate($dateYear, $dateMonth, 1);
        $date->setTime(0, 0, 0);

        // Next Month
        return $date->add(new \DateInterval("P1M"));
    }

    /**
     * Gets the previous month.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getPreviousMonth(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Date and Minutes...
        $dateYear = intval($date->format("Y"));
        $dateMonth = intval($date->format("m"));

        // Sets to first day of month
        $date->setDate($dateYear, $dateMonth, 1);
        $date->setTime(0, 0, 0);

        // Previous Month
        return $date->sub(new \DateInterval("P1M"));
    }

    /**
     * Gets the next week.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getNextWeek(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets to first day of week
        $date->setISODate($date->format("Y"), $date->format("W"), 1);

        // Next Week
        return $date->add(new \DateInterval("P7D"));
    }

    /**
     * Gets the previous week.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getPreviousWeek(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets to first day of week
        $date->setISODate($date->format("Y"), $date->format("W"), 1);

        // Previous Week
        return $date->sub(new \DateInterval("P7D"));
    }

    /**
     * Gets the next day.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getNextDay(\DateTimeInterface $date): \DateTimeInterface
    {
        $nextDay = $date->add(new \DateInterval('P1D'));

        // Sets the next day at midnight
        $nextDay->setTime(0, 0, 0);

        return $nextDay;
    }

    /**
     * Gets the next hour.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getNextHour(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Minutes and Second to zero
        $dateHour = intval($date->format('H'));
        $date->setTime($dateHour, 0, 0);

        return $date->add(new \DateInterval('PT1H'));
    }

    /**
     * Gets the previous hour.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getPreviousHour(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Minutes and Second to zero
        $dateHour = intval($date->format('H'));
        $date->setTime($dateHour, 0, 0);

        return $date->sub(new \DateInterval('PT1H'));
    }

    /**
     * Gets the next minute.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getNextMinute(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Second to zero
        $dateHour = intval($date->format('H'));
        $dateMinute = intval($date->format('i'));
        $date->setTime($dateHour, $dateMinute, 0);

        return $date->add(new \DateInterval('PT1M'));
    }

    /**
     * Gets the previous minute.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getPreviousMinute(\DateTimeInterface $date): \DateTimeInterface
    {
        // Sets Second to zero
        $dateHour = intval($date->format('H'));
        $dateMinute = intval($date->format('i'));
        $date->setTime($dateHour, $dateMinute, 0);

        return $date->sub(new \DateInterval('PT1M'));
    }

    /**
     * Gets the next second.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getNextSecond(\DateTimeInterface $date): \DateTimeInterface
    {
        return $date->add(new \DateInterval('PT1S'));
    }

    /**
     * Gets the previous second.
     *
     * @param \DateTimeInterface $date The Date.
     *
     * @return \DateTimeInterface The Date.
     */
    public static function getPreviousSecond(\DateTimeInterface $date): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('PT1S'));
    }

    /**
     * Builds time range.
     *
     * @param int $start The start.
     * @param int $end The end.
     *
     * @return array The range.
     */
    public static function buildTimeRange($start = 0, $end = 23): array
    {
        $range = [];

        foreach (range($start, $end) as $i) {
            $i = (string)$i;
            if (strlen($i) < 2) {
                $i = '0'.$i;
            }

            $range[] = $i;
        }

        return $range;
    }

    /**
     * Subtract seconds from date.
     *
     * @param \DateTimeInterface $date The Date.
     * @param int $seconds The second number.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function subtractSecondsFromDate(\DateTimeInterface $date, int $seconds): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('PT'.$seconds.'S'));
    }

    /**
     * Subtract minutes from date.
     *
     * @param \DateTimeInterface $date The Date.
     * @param int $minutes The minute number.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function subtractMinutesFromDate(\DateTimeInterface $date, int $minutes): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('PT'.$minutes.'M'));
    }

    /**
     * Subtract minutes from date.
     *
     * @param \DateTimeInterface $date The Date.
     * @param int $hours The hours number.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function subtractHoursFromDate(\DateTimeInterface $date, int $hours): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('PT'.$hours.'H'));
    }

    /**
     * Subtract days from date.
     *
     * @param \DateTimeInterface $date The Date.
     * @param int $days The days number.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function subtractDaysFromDate(\DateTimeInterface $date, int $days): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('P'.$days.'D'));
    }

    /**
     * Subtract weeks from date.
     *
     * @param \DateTimeInterface $date The Date.
     * @param int $weeks The weeks.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function subtractWeeksFromDate(\DateTimeInterface $date, int $weeks): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('P'.$weeks.'W'));
    }

    /**
     * Subtract weeks from date.
     *
     * @param \DateTimeInterface $date The Date.
     * @param int $months The months.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function subtractMonthsFromDate(\DateTimeInterface $date, int $months): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('P'.$months.'M'));
    }

    /**
     * Subtract years from date.
     *
     * @param \DateTimeInterface $date The Date.
     * @param int $years The years.
     *
     * @return \DateTimeInterface The Date.
     *
     * @throws \Exception
     */
    public static function subtractYearsFromDate(\DateTimeInterface $date, int $years): \DateTimeInterface
    {
        return $date->sub(new \DateInterval('P'.$years.'Y'));
    }

    /**
     * Gets the Time.
     *
     * @return int The Time.
     */
    public static function time(): int
    {
        return strtotime(Date::getNowDate()->format('Y-m-d H:i:s'));
    }
}
