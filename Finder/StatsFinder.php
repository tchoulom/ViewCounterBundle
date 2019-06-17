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
use Tchoulom\ViewCounterBundle\Statistics\Month;
use Tchoulom\ViewCounterBundle\Statistics\Page;
use Tchoulom\ViewCounterBundle\Statistics\Week;
use Tchoulom\ViewCounterBundle\Statistics\Year;
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
        if (null != $page) {
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
        if (null != $year) {
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
        if (null != $month) {
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
        if (null != $week) {
            $getDay = 'get' . ucfirst(strtolower($day));
            return $week->$getDay();
        }

        return null;
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