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

namespace Tchoulom\ViewCounterBundle\Statistics;

use Tchoulom\ViewCounterBundle\Adapter\Geolocator\GeolocatorAdapterInterface;
use Tchoulom\ViewCounterBundle\Geolocation\Country;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class Page
 */
class Page
{
    /**
     * The page ID.
     *
     * @var int
     */
    protected $id;

    /**
     * The total of views of the current page.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * The years.
     *
     * @var Year[]
     */
    protected $years = [];

    /**
     * The countries.
     *
     * @var Country[]
     */
    protected $countries = [];

    /**
     * Page constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Gets the Id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Gets the total of views.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Sets the total of views.
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
     * @return Year[]
     */
    public function getYears(): array
    {
        return $this->years;
    }

    /**
     * Gets the countries.
     *
     * @return Country[]
     */
    public function getCountries(): array
    {
        return $this->countries;
    }

    /**
     * Builds the year.
     *
     * @return self
     */
    public function buildYear(): self
    {
        $this->total++;
        $yearNumber = Date::getNowYear();

        if (isset($this->years[$yearNumber])) {
            $year = $this->years[$yearNumber];
        } else {
            $year = new Year();
        }

        $this->years[$yearNumber] = $year->buildMonth();

        return $this;
    }

    /**
     * Builds the country.
     *
     * @param GeolocatorAdapterInterface $geolocatorAdapter
     *
     * @return self
     */
    public function buildCountry(GeolocatorAdapterInterface $geolocatorAdapter): self
    {
        $countryName = $geolocatorAdapter->getCountry();

        if (isset($this->countries[$countryName])) {
            $country = $this->countries[$countryName];
        } else {
            $country = new Country();
        }

        $this->countries[$countryName] = $country->build($geolocatorAdapter);

        return $this;
    }
}
