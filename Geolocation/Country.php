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

namespace Tchoulom\ViewCounterBundle\Geolocation;

use Tchoulom\ViewCounterBundle\Adapter\Geolocator\GeolocatorAdapterInterface;
use Tchoulom\ViewCounterBundle\Statistics\ViewDateTrait;
use Tchoulom\ViewCounterBundle\Util\Date;
use Tchoulom\ViewCounterBundle\Statistics\Date as ViewDate;

/**
 * Class Country
 */
class Country
{
    /**
     * The region name.
     *
     * @var string
     */
    protected $name;

    /**
     * The total of views.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * The continent name.
     *
     * @var string
     */
    protected $continent;

    /**
     * The country regions.
     *
     * @var Region[]
     */
    protected $regions = [];

    use ViewDateTrait;

    /**
     * Gets the country name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the country name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
     * Gets the continent name.
     *
     * @return string
     */
    public function getContinent(): string
    {
        return $this->continent;
    }

    /**
     * Sets the continent name.
     *
     * @param string $continent
     *
     * @return self
     */
    public function setContinent(string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    /**
     * Gets the regions.
     *
     * @return Region[]
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * Builds the country.
     *
     * @param GeolocatorAdapterInterface $geolocatorAdapter
     *
     * @return self
     */
    public function build(GeolocatorAdapterInterface $geolocatorAdapter): self
    {
        $this->total++;
        $this->name = $geolocatorAdapter->getCountry();
        $this->buildViewDate();
        $this->continent = $geolocatorAdapter->getContinent();
        $regionName = $geolocatorAdapter->getRegion();

        if (isset($this->regions[$regionName])) {
            $region = $this->regions[$regionName];
        } else {
            $region = new Region();
        }

        $this->regions[$regionName] = $region->build($geolocatorAdapter);

        return $this;
    }
}
