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

namespace Tchoulom\ViewCounterBundle\Finder;

use Tchoulom\ViewCounterBundle\Manager\FileManagerInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Statistics\Day;
use Tchoulom\ViewCounterBundle\Statistics\Hour;
use Tchoulom\ViewCounterBundle\Statistics\Minute;
use Tchoulom\ViewCounterBundle\Statistics\Month;
use Tchoulom\ViewCounterBundle\Statistics\Page;
use Tchoulom\ViewCounterBundle\Statistics\Week;
use Tchoulom\ViewCounterBundle\Statistics\Year;
use Tchoulom\ViewCounterBundle\Util\Date;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;
use Tchoulom\ViewCounterBundle\Statistics\Second;

/**
 * Class StatsFinder
 */
class StatsFinder
{
    /**
     * @var FileManagerInterface
     */
    protected $fileManager;

    /**
     * @var array|bool|mixed|string
     */
    protected $stats = [];

    /**
     * StatsFinder constructor.
     *
     * @param FileManagerInterface $fileManager
     */
    public function __construct(FileManagerInterface $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    /**
     * Finds the stats contents by page.
     *
     * @param ViewCountable $page
     *
     * @return Page|null
     *
     * @throws \ReflectionException
     */
    public function findByPage(ViewCountable $page): ?Page
    {
        $class = (new ReflectionExtractor())->getClassNamePluralized($page);
        $pageId = $page->getId();
        $this->stats = $this->loadContents();

        if (isset($this->stats[$class][$pageId])) {
            return $this->stats[$class][$pageId];
        }

        return null;
    }

    /**
     * Finds the stats contents by year.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     *
     * @return Year|null
     *
     * @throws \ReflectionException
     */
    public function findByYear(ViewCountable $page, $yearNumber): ?Year
    {
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$yearNumber])) {
                return $page->getYears()[$yearNumber];
            }
        }

        return null;
    }

    /**
     * Finds the stats contents by month.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     *
     * @return Month|null
     *
     * @throws \ReflectionException
     */
    public function findByMonth(ViewCountable $page, $yearNumber, $monthNumber): ?Month
    {
        $year = $this->findByYear($page, $yearNumber);

        if ($year instanceof Year) {
            if (isset($year->getMonths()[$monthNumber])) {
                return $year->getMonths()[$monthNumber];
            }
        }

        return null;
    }

    /**
     * Finds the stats contents by week.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     *
     * @return Week|null
     *
     * @throws \ReflectionException
     */
    public function findByWeek(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber): ?Week
    {
        $month = $this->findByMonth($page, $yearNumber, $monthNumber);

        if ($month instanceof Month) {
            if (isset($month->getWeeks()[$weekNumber])) {
                return $month->getWeeks()[$weekNumber];
            }
        }

        return null;
    }

    /**
     * Finds the stats contents by day.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     * @param $dayName
     *
     * @return Day|null
     *
     * @throws \ReflectionException
     */
    public function findByDay(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName): ?Day
    {
        $week = $this->findByWeek($page, $yearNumber, $monthNumber, $weekNumber);

        if ($week instanceof Week) {
            $getDay = 'get' . ucfirst(strtolower($dayName));
            return $week->$getDay();
        }

        return null;
    }

    /**
     * Finds the stats contents by hour.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     * @param $dayName
     * @param $hourName
     *
     * @return Hour|null
     *
     * @throws \ReflectionException
     */
    public function findByHour(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName): ?Hour
    {
        $day = $this->findByDay($page, $yearNumber, $monthNumber, $weekNumber, $dayName);

        if ($day instanceof Day) {
            return $day->getHour($hourName);
        }

        return null;
    }

    /**
     * Finds the stats contents by minute.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     * @param $dayName
     * @param $hourName
     * @param $minuteName
     *
     * @return Minute|null
     *
     * @throws \ReflectionException
     */
    public function findByMinute(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName, $minuteName): ?Minute
    {
        $hour = $this->findByHour($page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName);

        if ($hour instanceof Hour) {
            return $hour->getMinute($minuteName);
        }

        return null;
    }

    /**
     * Finds the stats contents by second.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     * @param $dayName
     * @param $hourName
     * @param $minuteName
     * @param $secondName
     *
     * @return Second|null
     *
     * @throws \ReflectionException
     */
    public function findBySecond(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName, $minuteName, $secondName): ?Second
    {
        $minute = $this->findByMinute($page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName, $minuteName);

        if ($minute instanceof Minute) {
            return $minute->getSecond($secondName);
        }

        return null;
    }

    /**
     * Gets the yearly stats.
     *
     * @param ViewCountable $page
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function getYearlyStats(ViewCountable $page): array
    {
        $yearlyStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            $years = $page->getYears();
            foreach ($years as $year) {
                $yearlyStats[] = [$year->getYearNumber(), $year->getTotal()];
            }
        }

        return $yearlyStats;
    }

    /**
     * Gets the monthly stats.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function getMonthlyStats(ViewCountable $page, $yearNumber): array
    {
        $monthlyStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$yearNumber])) {
                $year = $page->getYears()[$yearNumber];
                foreach ($year->getMonths() as $month) {
                    $monthlyStats[] = [$month->getMonthNumber(), $month->getTotal()];
                }
            }
        }

        return $monthlyStats;
    }

    /**
     * Gets the weekly stats.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function getWeeklylyStats(ViewCountable $page, $yearNumber, $monthNumber): array
    {
        $weeklyStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$yearNumber])) {
                $year = $page->getYears()[$yearNumber];
                if (isset($year->getMonths()[$monthNumber])) {
                    $month = $year->getMonths()[$monthNumber];
                    foreach ($month->getWeeks() as $week) {
                        $weeklyStats[] = [$week->getWeekNumber(), $week->getTotal()];
                    }
                }
            }
        }

        return $weeklyStats;
    }

    /**
     * Gets the daily stats.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function getDailyStats(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber): array
    {
        $dailyStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$yearNumber])) {
                $year = $page->getYears()[$yearNumber];
                if (isset($year->getMonths()[$monthNumber])) {
                    $month = $year->getMonths()[$monthNumber];
                    if (isset($month->getWeeks()[$weekNumber])) {
                        $week = $month->getWeeks()[$weekNumber];
                        $weekDaysName = Date::getWeekDaysName();
                        foreach ($weekDaysName as $dayName) {
                            $day = $week->getDay($dayName);
                            $dailyStats[] = [$day->getName(), $day->getTotal()];
                        }
                    }
                }
            }
        }

        return $dailyStats;
    }

    /**
     * Gets the hourly stats.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     * @param $dayName
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function getHourlyStats(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName): array
    {
        $hourlyStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$yearNumber])) {
                $year = $page->getYears()[$yearNumber];
                if (isset($year->getMonths()[$monthNumber])) {
                    $month = $year->getMonths()[$monthNumber];
                    if (isset($month->getWeeks()[$weekNumber])) {
                        $week = $month->getWeeks()[$weekNumber];
                        $day = $week->getDay($dayName);
                        $hoursRange = Date::buildTimeRange(0, 23);
                        foreach ($hoursRange as $hourRangeName) {
                            $hourName = 'h' . $hourRangeName;
                            $hour = $day->getHour($hourName);
                            $hourlyStats[] = [$hourRangeName, $hour->getTotal()];
                        }
                    }
                }
            }
        }

        return $hourlyStats;
    }

    /**
     * Gets the stats per minute.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     * @param $dayName
     * @param $hourName
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function getStatsPerMinute(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName): array
    {
        $statsPerMinute = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$yearNumber])) {
                $year = $page->getYears()[$yearNumber];
                if (isset($year->getMonths()[$monthNumber])) {
                    $month = $year->getMonths()[$monthNumber];
                    if (isset($month->getWeeks()[$weekNumber])) {
                        $week = $month->getWeeks()[$weekNumber];
                        $day = $week->getDay($dayName);
                        $hour = $day->getHour($hourName);
                        $minutesRange = Date::buildTimeRange(0, 59);
                        foreach ($minutesRange as $minuteRangeName) {
                            $minuteName = 'm' . $minuteRangeName;
                            $minute = $hour->getMinute($minuteName);
                            $statsPerMinute[] = [$minuteRangeName, $minute->getTotal()];
                        }
                    }
                }
            }
        }

        return $statsPerMinute;
    }

    /**
     * Gets the stats per second.
     *
     * @param ViewCountable $page
     * @param $yearNumber
     * @param $monthNumber
     * @param $weekNumber
     * @param $dayName
     * @param $hourName
     * @param $minuteName
     *
     * @return array
     *
     * @throws \ReflectionException
     */
    public function getStatsPerSecond(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName, $minuteName): array
    {
        $statsPerSecond = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$yearNumber])) {
                $year = $page->getYears()[$yearNumber];
                if (isset($year->getMonths()[$monthNumber])) {
                    $month = $year->getMonths()[$monthNumber];
                    if (isset($month->getWeeks()[$weekNumber])) {
                        $week = $month->getWeeks()[$weekNumber];
                        $day = $week->getDay($dayName);
                        $hour = $day->getHour($hourName);
                        $minute = $hour->getMinute($minuteName);
                        $secondsRange = Date::buildTimeRange(0, 59);
                        foreach ($secondsRange as $secondRangeName) {
                            $secondName = 's' . $secondRangeName;
                            $second = $minute->getSecond($secondName);
                            $statsPerSecond[] = [$secondRangeName, $second->getTotal()];
                        }
                    }
                }
            }
        }

        return $statsPerSecond;
    }

    /**
     * Loads the contents.
     *
     * @return array|bool|mixed|string
     */
    public function loadContents()
    {
        $this->stats = $this->fileManager->loadContents();

        return $this->stats;
    }

    /**
     * Gets the stats contents.
     *
     * @return array|bool|mixed|string
     */
    public function getStats()
    {
        return $this->stats;
    }
}
