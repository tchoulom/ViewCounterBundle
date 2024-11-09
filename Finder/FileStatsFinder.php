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

namespace Tchoulom\ViewCounterBundle\Finder;

use Tchoulom\ViewCounterBundle\Storage\Filesystem\FilesystemStorageInterface;
use Tchoulom\ViewCounterBundle\Geolocation\City;
use Tchoulom\ViewCounterBundle\Geolocation\Country;
use Tchoulom\ViewCounterBundle\Geolocation\Region;
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
 * Class FileStatsFinder
 */
class FileStatsFinder
{
    /**
     * The FilesystemStorage.
     *
     * @var FilesystemStorageInterface
     */
    protected $filesystemStorage;

    /**
     * The stats contents.
     *
     * @var array|bool|mixed|string
     */
    protected $stats = [];

    /**
     * FileStatsFinder constructor.
     * 
     * @param FilesystemStorageInterface $filesystemStorage
     */
    public function __construct(FilesystemStorageInterface $filesystemStorage)
    {
        $this->filesystemStorage = $filesystemStorage;
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
        $class = ReflectionExtractor::getClassNamePluralized($page);
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The yaer number
     *
     * @return Year|null The Year?
     *
     * @throws \ReflectionException
     */
    public function findByYear(ViewCountable $page, int $yearNumber): ?Year
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     *
     * @return Month|null
     *
     * @throws \ReflectionException
     */
    public function findByMonth(ViewCountable $page, int $yearNumber, int $monthNumber): ?Month
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     *
     * @return Week|null The week?
     *
     * @throws \ReflectionException
     */
    public function findByWeek(ViewCountable $page, int $yearNumber, int $monthNumber, int $weekNumber): ?Week
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The yaer number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     * @param string $dayName The day name
     *
     * @return Day|null The Day?
     *
     * @throws \ReflectionException
     */
    public function findByDay(
        ViewCountable $page,
        int $yearNumber,
        int $monthNumber,
        int $weekNumber,
        string $dayName
    ): ?Day {
        $week = $this->findByWeek($page, $yearNumber, $monthNumber, $weekNumber);

        if ($week instanceof Week) {
            $getDay = 'get'.ucfirst(strtolower($dayName));

            return $week->$getDay();
        }

        return null;
    }

    /**
     * Finds the stats contents by hour.
     *
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     * @param string $dayName The day name
     * @param string $hourName The hour name
     *
     * @return Hour|null The Hour?
     *
     * @throws \ReflectionException
     */
    public function findByHour(
        ViewCountable $page,
        int $yearNumber,
        int $monthNumber,
        int $weekNumber,
        string $dayName,
        string $hourName
    ): ?Hour {
        $day = $this->findByDay($page, $yearNumber, $monthNumber, $weekNumber, $dayName);

        if ($day instanceof Day) {
            return $day->getHour($hourName);
        }

        return null;
    }

    /**
     * Finds the stats contents by minute.
     *
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     * @param string $dayName The day name
     * @param string $hourName The hour name
     * @param string $minuteName The minute name
     *
     * @return Minute|null The Minute?
     *
     * @throws \ReflectionException
     */
    public function findByMinute(
        ViewCountable $page,
        int $yearNumber,
        int $monthNumber,
        int $weekNumber,
        string $dayName,
        string $hourName,
        string $minuteName
    ): ?Minute {
        $hour = $this->findByHour($page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName);

        if ($hour instanceof Hour) {
            return $hour->getMinute($minuteName);
        }

        return null;
    }

    /**
     * Finds the stats contents by second.
     *
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     * @param string $dayName The day name
     * @param string $hourName The hour name
     * @param string $minuteName The minute name
     * @param string $secondName The second name
     *
     * @return Second|null The Second?
     *
     * @throws \ReflectionException
     */
    public function findBySecond(
        ViewCountable $page,
        int $yearNumber,
        int $monthNumber,
        int $weekNumber,
        string $dayName,
        string $hourName,
        string $minuteName,
        string $secondName
    ): ?Second {
        $minute = $this->findByMinute($page, $yearNumber, $monthNumber, $weekNumber, $dayName, $hourName, $minuteName);

        if ($minute instanceof Minute) {
            return $minute->getSecond($secondName);
        }

        return null;
    }

    /**
     * Gets the given ViewCountable Page stats.
     *
     * @param ViewCountable $page The ViewCountable Page
     *
     * @return int The Page stats
     */
    public function getPageStats(ViewCountable $page): int
    {
        $page = $this->findByPage($page);
        if ($page instanceof Page) {
            return $page->getTotal();
        }

        return 0;
    }

    /**
     * Gets the yearly stats.
     *
     * @param ViewCountable $page
     *
     * @return array The yearly stats
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     *
     * @return array The monthly stats
     *
     * @throws \ReflectionException
     */
    public function getMonthlyStats(ViewCountable $page, int $yearNumber): array
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber the year number
     * @param int $monthNumber The month number
     *
     * @return array The weekly stats
     *
     * @throws \ReflectionException
     */
    public function getWeeklylyStats(ViewCountable $page, int $yearNumber, int $monthNumber): array
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     *
     * @return array The daiky stats
     *
     * @throws \ReflectionException
     */
    public function getDailyStats(ViewCountable $page, int $yearNumber, int $monthNumber, int $weekNumber): array
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     * @param string $dayName The day name
     *
     * @return array The hourly stats
     *
     * @throws \ReflectionException
     */
    public function getHourlyStats(
        ViewCountable $page,
        int $yearNumber,
        int $monthNumber,
        int $weekNumber,
        string $dayName
    ): array {
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
                            $hourName = 'h'.$hourRangeName;
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     * @param string $dayName The day name
     * @param string $hourName The hour name
     *
     * @return array The stats per minute
     *
     * @throws \ReflectionException
     */
    public function getStatsPerMinute(
        ViewCountable $page,
        int $yearNumber,
        int $monthNumber,
        int $weekNumber,
        string $dayName,
        string $hourName
    ): array {
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
                            $minuteName = 'm'.$minuteRangeName;
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
     * @param ViewCountable $page The viewcountable Page
     * @param int $yearNumber The year number
     * @param int $monthNumber The month number
     * @param int $weekNumber The week number
     * @param string $dayName The day name
     * @param string $hourName The hour name
     * @param string $minuteName The minute name
     *
     * @return array The stats per second
     *
     * @throws \ReflectionException
     */
    public function getStatsPerSecond(
        ViewCountable $page,
        int $yearNumber,
        int $monthNumber,
        int $weekNumber,
        string $dayName,
        string $hourName,
        string $minuteName
    ): array {
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
                            $secondName = 's'.$secondRangeName;
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
     * Gets the countries stats.
     *
     * @param ViewCountable $page The given viewcountable page
     *
     * @return array The countries stats
     *
     * @throws \ReflectionException
     */
    public function getCountryStats(ViewCountable $page): array
    {
        $countriesStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            foreach ($page->getCountries() as $country) {
                $countriesStats[] = [$country->getName(), $country->getTotal()];
            }
        }

        return $countriesStats;
    }

    /**
     * Gets the regions stats.
     *
     * @param ViewCountable $page The given viewcountable Page
     *
     * @return array The regions stats
     *
     * @throws \ReflectionException
     */
    public function getRegionStats(ViewCountable $page): array
    {
        $regionsStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            foreach ($page->getCountries() as $country) {
                foreach ($country->getRegions() as $region) {
                    $regionsStats[] = [$region->getName(), $region->getTotal()];
                }
            }
        }

        return $regionsStats;
    }

    /**
     * Gets the cities stats.
     *
     * @param ViewCountable $page The given viewcounter Page
     *
     * @return array The cities stats
     *
     * @throws \ReflectionException
     */
    public function getCityStats(ViewCountable $page): array
    {
        $citiesStats = [];
        $page = $this->findByPage($page);

        if ($page instanceof Page) {
            foreach ($page->getCountries() as $country) {
                foreach ($country->getRegions() as $region) {
                    foreach ($region->getCities() as $city) {
                        $citiesStats[] = [$city->getName(), $city->getTotal()];
                    }
                }
            }
        }

        return $citiesStats;
    }

    /**
     * Finds by country.
     *
     * @param ViewCountable $page The viewcountable Page
     * @param string $countryName The country name.
     *
     * @return Country|null The country?
     *
     * @throws \ReflectionException
     */
    public function findByCountry(ViewCountable $page, string $countryName): ?Country
    {
        $page = $this->findByPage($page);
        if ($page instanceof Page) {
            if (isset($page->getCountries()[$countryName])) {
                return $page->getCountries()[$countryName];
            }
        }

        return null;
    }

    /**
     * Finds by region.
     *
     * @param ViewCountable $page The viewcountable Page
     * @param string $countryName The country name
     * @param string $regionName The region name
     *
     * @return Region|null The Region?
     *
     * @throws \ReflectionException
     */
    public function findByRegion(ViewCountable $page, string $countryName, string $regionName): ?Region
    {
        $country = $this->findByCountry($page, $countryName);
        if ($country instanceof Country) {
            if (isset($country->getRegions()[$regionName])) {
                return $country->getRegions()[$regionName];
            }
        }

        return null;
    }

    /**
     * Finds by city.
     *
     * @param ViewCountable $page The viewcounter Page
     * @param string $countryName The country name
     * @param string $regionName The region name
     * @param string $cityName The city name
     *
     * @return City|null The city?
     *
     * @throws \ReflectionException
     */
    public function findByCity(ViewCountable $page, string $countryName, string $regionName, string $cityName): ?City
    {
        $region = $this->findByRegion($page, $countryName, $regionName);
        if ($region instanceof Region) {
            if (isset($region->getCities()[$cityName])) {
                return $region->getCities()[$cityName];
            }
        }

        return null;
    }

    /**
     * Gets the stats by country.
     *
     * @param ViewCountable $page The viewcounter Page
     * @param string $countryName The country name
     *
     * @return int The country stats
     *
     * @throws \ReflectionException
     */
    public function getStatsByCountry(ViewCountable $page, string $countryName): int
    {
        $country = $this->findByCountry($page, $countryName);
        if ($country instanceof Country) {
            return $country->getTotal();
        }

        return 0;
    }

    /**
     * Gets the stats by region.
     *
     * @param ViewCountable $page The viewcounter Page
     * @param string $countryName The country name
     * @param string $regionName The region name
     *
     * @return int The region stats
     *
     * @throws \ReflectionException
     */
    public function getStatsByRegion(ViewCountable $page, string $countryName, string $regionName): int
    {
        $region = $this->findByRegion($page, $countryName, $regionName);
        if ($region instanceof Region) {
            return $region->getTotal();
        }

        return 0;
    }

    /**
     * Gets the stats by city.
     *
     * @param ViewCountable $page The viewcounter Page
     * @param string $countryName The country name
     * @param string $regionName The region name
     * @param string $cityName The city name
     *
     * @return int The city stats
     *
     * @throws \ReflectionException
     */
    public function getStatsByCity(ViewCountable $page, string $countryName, string $regionName, string $cityName): int
    {
        $city = $this->findByCity($page, $countryName, $regionName, $cityName);
        if ($city instanceof City) {
            return $city->getTotal();
        }

        return 0;
    }

    /**
     * Loads the contents.
     *
     * @return array|bool|mixed|string
     */
    public function loadContents()
    {
        $this->stats = $this->filesystemStorage->loadContents();

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
