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

use Tchoulom\ViewCounterBundle\Filesystem\FilesystemInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Statistics\Day;
use Tchoulom\ViewCounterBundle\Statistics\Hour;
use Tchoulom\ViewCounterBundle\Statistics\Month;
use Tchoulom\ViewCounterBundle\Statistics\Page;
use Tchoulom\ViewCounterBundle\Statistics\Week;
use Tchoulom\ViewCounterBundle\Statistics\Year;
use Tchoulom\ViewCounterBundle\Util\Date;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class StatsFinder
 */
class StatsFinder
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * @var array|bool|mixed|string
     */
    protected $stats = [];

    /**
     * Statistics constructor.
     *
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Finds the stats contents by page.
     *
     * @param ViewCountable $page
     *
     * @return Page|null
     */
    public function findByPage(ViewCountable $page)
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
     * @param $year
     *
     * @return Year|null
     */
    public function findByYear(ViewCountable $page, $year)
    {
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            if (isset($page->getYears()[$year])) {
                return $page->getYears()[$year];
            }
        }

        return null;
    }

    /**
     * Finds the stats contents by month.
     *
     * @param ViewCountable $page
     * @param $year
     * @param $month
     *
     * @return Month|null
     */
    public function findByMonth(ViewCountable $page, $year, $month)
    {
        $year = $this->findByYear($page, $year);

        if ($year instanceof Year) {
            if (isset($year->getMonths()[$month])) {
                return $year->getMonths()[$month];
            }
        }

        return null;
    }

    /**
     * Finds the stats contents by week.
     *
     * @param ViewCountable $page
     * @param $year
     * @param $month
     * @param $week
     *
     * @return Week|null
     */
    public function findByWeek(ViewCountable $page, $year, $month, $week)
    {
        $month = $this->findByMonth($page, $year, $month);

        if ($month instanceof Month) {
            if (isset($month->getWeeks()[$week])) {
                return $month->getWeeks()[$week];
            }
        }

        return null;
    }

    /**
     * Finds the stats contents by day.
     *
     * @param ViewCountable $page
     * @param $year
     * @param $month
     * @param $week
     * @param $day
     *
     * @return Day|null
     */
    public function findByDay(ViewCountable $page, $year, $month, $week, $day)
    {
        $week = $this->findByWeek($page, $year, $month, $week);

        if ($week instanceof Week) {
            $getDay = 'get' . ucfirst(strtolower($day));
            return $week->$getDay();
        }

        return null;
    }

    /**
     * Finds the stats contents by hour.
     *
     * @param ViewCountable $page
     * @param $year
     * @param $month
     * @param $week
     * @param $day
     * @param $hour
     *
     * @return Hour|null
     */
    public function findByHour(ViewCountable $page, $year, $month, $week, $day, $hour)
    {
        $day = $this->findByDay($page, $year, $month, $week, $day);

        if ($day instanceof Day) {
            return $day->getHour($hour);
        }

        return null;
    }

    /**
     * Gets the yearly stats.
     *
     * @param ViewCountable $page
     *
     * @return array
     */
    public function getYearlyStats(ViewCountable $page)
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
     */
    public function getMonthlyStats(ViewCountable $page, $yearNumber)
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
     */
    public function getWeeklylyStats(ViewCountable $page, $yearNumber, $monthNumber)
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
     */
    public function getDailyStats(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber)
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
     */
    public function getHourlyStats(ViewCountable $page, $yearNumber, $monthNumber, $weekNumber, $dayName)
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
                        $dayHours = Date::getDayHours();
                        foreach ($dayHours as $dayHour) {
                            $hourName = 'h' . $dayHour;
                            $hour = $day->getHour($hourName);
                            $hourlyStats[] = [$dayHour, $hour->getTotal()];
                        }
                    }
                }
            }
        }

        return $hourlyStats;
    }

    /**
     * Loads the contents.
     *
     * @return array|bool|mixed|string
     */
    public function loadContents()
    {
        $this->stats = $this->filesystem->loadContents();

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