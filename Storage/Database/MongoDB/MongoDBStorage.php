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

namespace Tchoulom\ViewCounterBundle\Storage\Database\MongoDB;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Tchoulom\ViewCounterBundle\Adapter\Geolocator\GeolocatorAdapterInterface;
use Tchoulom\ViewCounterBundle\Adapter\Storage\StorageAdapterInterface;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\City;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Continent;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Country;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Day;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Hour;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Minute;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Month;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Page;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\PageContinent;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\PageCountry;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Region;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Second;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Week;
use Tchoulom\ViewCounterBundle\Document\Stats\MongoDB\Year;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Util\Date;
use DateTimeInterface;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class MongoDBStorage is used to save statistics in a MongoDB via doctrine/mongodb-odm-bundle.
 * @package Tchoulom\ViewCounterBundle\Storage\Database
 */
class MongoDBStorage implements DocumentStorageInterface, StorageAdapterInterface
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * @var DateTimeInterface The view date.
     */
    protected $viewDate;

    /**
     * @var Year
     */
    protected $year;

    /**
     * @var Month
     */
    protected $month;

    /**
     * @var Week
     */
    protected $week;

    /**
     * @var Day
     */
    protected $day;

    /**
     * @var Hour
     */
    protected $hour;

    /**
     * @var Minute
     */
    protected $minute;

    /**
     * @var Second
     */
    protected $second;

    /**
     * @var PageContinent
     */
    protected $pageContinent;

    /**
     * @var Continent
     */
    protected $continent;

    /**
     * @var PageCountry
     */
    protected $pageCountry;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var Region
     */
    protected $region;

    /**
     * @var City
     */
    protected $city;

    /**
     * The DocumentManager.
     *
     * @var DocumentManager The DocumentManager.
     */
    protected $dm;

    /**
     * The Geolocator
     *
     * @var GeolocatorAdapterInterface The geolocator.
     */
    protected $geolocator;

    /**
     * MongoDBStorage constructor.
     *
     * @param DocumentManager|null $dm
     * @param GeolocatorAdapterInterface $geolocator
     */
    public function __construct(?DocumentManager $dm, GeolocatorAdapterInterface $geolocator)
    {
        $this->dm = $dm;
        $this->geolocator = $geolocator;
    }

    /**
     * Finds a single object by a set of criteria.
     *
     * @param string $documentName The document name.
     * @param array $criteria The criteria.
     *
     * @return object|null The object.
     */
    public function findOneBy(string $documentName, array $criteria)
    {
        return $this->dm->getRepository($documentName)->findOneBy($criteria);
    }

    /**
     * Saves the statistics.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @throws MongoDBException
     */
    public function save(ViewCounterInterface $viewcounter): void
    {
        try {
            $this->build($viewcounter);
            $this->dm->flush();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Builds the stats for MongoDB engine.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     */
    public function build(ViewCounterInterface $viewcounter): void
    {
        $this->viewDate = $viewcounter->getViewDate();

        $this->buildPage($viewcounter)
            ->buildYear($this->page)
            ->buildMonth($this->year)
            ->buildWeek($this->month)
            ->buildDay($this->week)
            ->buildHour($this->day)
            ->buildMinute($this->hour)
            ->buildSecond($this->minute);

        if ($this->geolocator->canGeolocate()) {
            $this->buildContinent($this->page)
                ->buildCountry($this->pageContinent)
                ->buildRegion($this->pageCountry)
                ->buildCity($this->region);
        }
    }

    /**
     * Builds the Page.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return self
     */
    public function buildPage(ViewCounterInterface $viewcounter): self
    {
        $pageRef = $viewcounter->getPage();
        $classRef = ReflectionExtractor::getShortClassName($pageRef);
        $page = $this->findOneBy(Page::class, ['classRef' => $classRef, 'pageRef' => $pageRef->getId()]);

        if (!$page instanceof Page) {
            $page = new Page();
            $page->setPageRef($pageRef->getId());
            $page->setClassRef($classRef);
            $this->dm->persist($page);
        }

        $page->setViewDate($this->viewDate);
        $page->increaseViews();
        $this->page = $page;

        return $this;
    }

    /**
     * Builds the year.
     *
     * @param Page $page The page.
     *
     * @return self
     */
    public function buildYear(Page $page): self
    {
        $year = $this->findOneBy(Year::class, ['page' => $page, 'number' => $this->viewDate->format('Y')]);

        if (!$year instanceof Year) {
            $year = new Year();
            $year->setNumber($this->viewDate->format('Y'));
            $page->addYear($year);
            $this->dm->persist($year);
        }

        $year->increaseViews();
        $this->year = $year;

        return $this;
    }

    /**
     * Builds the month.
     *
     * @param Year $year The year.
     *
     * @return self
     */
    public function buildMonth(Year $year): self
    {
        $month = $this->findOneBy(Month::class, ['year' => $year, 'number' => $this->viewDate->format('m')]);

        if (!$month instanceof Month) {
            $month = new Month();
            $month->setNumber($this->viewDate->format('m'));
            $year->addMonth($month);
            $this->dm->persist($month);
        }

        $month->increaseViews();
        $this->month = $month;

        return $this;
    }

    /**
     * Builds the week.
     *
     * @param Month $month The month.
     *
     * @return self
     */
    public function buildWeek(Month $month): self
    {
        $week = $this->findOneBy(Week::class, ['month' => $month, 'number' => $this->viewDate->format('W')]);

        if (!$week instanceof Week) {
            $week = new Week();
            $week->setNumber($this->viewDate->format('W'));
            $month->addWeek($week);
            $this->dm->persist($week);
        }

        $week->increaseViews();
        $this->week = $week;

        return $this;
    }

    /**
     * Builds the day.
     *
     * @param Week $week The week.
     *
     * @return self
     */
    public function buildDay(Week $week): self
    {
        $day = $this->findOneBy(Day::class, ['week' => $week, 'name' => $this->viewDate->format('l')]);

        if (!$day instanceof Day) {
            $day = new Day();
            $day->setName($this->viewDate->format('l'));
            $week->addDay($day);
            $this->dm->persist($day);
        }

        $day->increaseViews();
        $this->day = $day;

        return $this;
    }

    /**
     * Builds the hour.
     *
     * @param Day $day The day.
     *
     * @return self
     */
    public function buildHour(Day $day): self
    {
        $hour = $this->findOneBy(Hour::class, ['day' => $day, 'name' => $this->viewDate->format('H')]);

        if (!$hour instanceof Hour) {
            $hour = new Hour();
            $hour->setName($this->viewDate->format('H'));
            $day->addHour($hour);
            $this->dm->persist($hour);
        }

        $hour->increaseViews();
        $this->hour = $hour;

        return $this;
    }

    /**
     * Builds the minute.
     *
     * @param Hour $hour The hour.
     *
     * @return self
     */
    public function buildMinute(Hour $hour): self
    {
        $minute = $this->findOneBy(Minute::class, ['hour' => $hour, 'name' => $this->viewDate->format('i')]);

        if (!$minute instanceof Minute) {
            $minute = new Minute();
            $minute->setName($this->viewDate->format('i'));
            $hour->addMinute($minute);
            $this->dm->persist($minute);
        }

        $minute->increaseViews();
        $this->minute = $minute;

        return $this;
    }

    /**
     * Builds the second.
     *
     * @param Minute $minute The minute.
     *
     * @return self
     */
    public function buildSecond(Minute $minute): self
    {
        $second = $this->findOneBy(Second::class, ['minute' => $minute, 'name' => $this->viewDate->format('s')]);

        if (!$second instanceof Second) {
            $second = new Second();
            $second->setName($this->viewDate->format('s'));
            $minute->addSecond($second);
        }

        $second->increaseViews();
        $this->second = $second;

        return $this;
    }

    /**
     * Builds the continent.
     *
     * @param Page $page The page.
     *
     * @return self
     */
    public function buildContinent(Page $page): self
    {
        $continent = $this->findOneBy(Continent::class, ['name' => $this->geolocator->getContinent()]);
        $pageContinent = $this->findOneBy(PageContinent::class, ['page' => $page, 'continent' => $continent]);

        if (!$pageContinent instanceof PageContinent) {
            if (!$continent instanceof Continent) {
                $continent = new Continent();
                $continent->setName($this->geolocator->getContinent());
                $this->dm->persist($continent);
            }

            $pageContinent = new PageContinent();
            $pageContinent->setPage($page);
            $pageContinent->setContinent($continent);
            $this->dm->persist($pageContinent);
        }

        $continent->increaseViews();
        $pageContinent->increaseViews();

        $this->pageContinent = $pageContinent;
        $this->continent = $continent;

        return $this;
    }

    /**
     * Builds the country.
     *
     * @param PageContinent $pageContinent The pageContinent.
     *
     * @return self
     */
    public function buildCountry(PageContinent $pageContinent): self
    {
        $country = $this->findOneBy(Country::class, ['name' => $this->geolocator->getCountry()]);
        $pageCountry = $this->findOneBy(PageCountry::class, ['page' => $pageContinent->getPage(), 'country' => $country]);

        if (!$pageCountry instanceof PageCountry) {
            if (!$country instanceof Country) {
                $country = new Country();
                $country->setName($this->geolocator->getCountry());
                $country->setContinent($pageContinent->getContinent());
                $this->dm->persist($country);
            }

            $pageCountry = new PageCountry();
            $pageCountry->setPage($pageContinent->getPage());
            $pageCountry->setCountry($country);
            $this->dm->persist($pageCountry);
        }

        $country->increaseViews();
        $pageCountry->increaseViews();

        $this->pageCountry = $pageCountry;
        $this->country = $country;

        return $this;
    }

    /**
     * Builds the region.
     *
     * @param PageCountry $pageCountry The PageCountry.
     *
     * @return self
     */
    public function buildRegion(PageCountry $pageCountry): self
    {
        $region = $this->findOneBy(Region::class, ['pageCountry' => $pageCountry, 'name' => $this->geolocator->getRegion()]);

        if (!$region instanceof Region) {
            $region = new Region();
            $region->setName($this->geolocator->getRegion());
            $region->setPageCountry($pageCountry);
            $this->dm->persist($region);
        }

        $region->increaseViews();
        $this->region = $region;

        return $this;
    }

    /**
     * Builds the city.
     *
     * @param Region $region The region.
     *
     * @return self
     */
    public function buildCity(Region $region): self
    {
        $city = $this->findOneBy(City::class, ['region' => $region, 'name' => $this->geolocator->getCity()]);

        if (!$city instanceof City) {
            $city = new City();
            $city->setName($this->geolocator->getCity());
            $region->addCity($city);
            $this->dm->persist($city);
        }

        $city->increaseViews();
        $this->city = $city;

        return $this;
    }
}
