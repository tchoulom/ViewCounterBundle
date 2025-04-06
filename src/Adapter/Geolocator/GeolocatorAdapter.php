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

namespace Tchoulom\ViewCounterBundle\Adapter\Geolocator;

use Tchoulom\ViewCounterBundle\Exception\RuntimeException;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class GeolocatorAdapter
 */
class GeolocatorAdapter implements GeolocatorAdapterInterface
{
    /**
     * The given Geolocator service.
     * This service must implements the "GeolocatorAdapterInterface".
     *
     * @var GeolocatorAdapterInterface|null
     */
    protected $geolocator;

    /**
     * The criteria is not supported message.
     *
     * @var string
     */
    protected const GEOLOCATOR_NOT_SUPPORTED_MSG = '%s service must implement the "Tchoulom\ViewCounterBundle\Adapter\Geolocator\GeolocatorAdapterInterface".';

    /**
     * GeolocatorAdapter constructor.
     *
     * @param GeolocatorAdapterInterface|null $geolocator The given Geolocator service
     */
    public function __construct(?GeolocatorAdapterInterface $geolocator)
    {
        if (!$this->supports($geolocator)) {
            throw new RuntimeException(sprintf(self::GEOLOCATOR_NOT_SUPPORTED_MSG,
                ReflectionExtractor::getFullClassName($geolocator)));
        }

        $this->geolocator = $geolocator;
    }

    /**
     * Gets the Geolocator service.
     *
     * @return GeolocatorAdapterInterface|null The Geolocator service
     */
    public function getGeolocator(): ?GeolocatorAdapterInterface
    {
        return $this->geolocator;
    }

    /**
     * The record returned.
     *
     * @return mixed The record
     */
    public function getRecord()
    {
        return $this->geolocator->getRecord();
    }

    /**
     * Gets the continent name.
     *
     * @return string The continent name
     */
    public function getContinent(): string
    {
        return $this->geolocator->getContinent();
    }

    /**
     * Gets the country name.
     *
     * @return string The country name
     */
    public function getCountry(): string
    {
        return $this->geolocator->getCountry();
    }

    /**
     * Gets the region name.
     *
     * @return string The region name
     */
    public function getRegion(): string
    {
        return $this->geolocator->getRegion();
    }

    /**
     * Gets the city name.
     *
     * @return string The city name
     */
    public function getCity(): string
    {
        return $this->geolocator->getCity();
    }

    /**
     * Allows to check if we can geolocate.
     *
     * @return bool Can use the Geolocator service?
     */
    public function canGeolocate(): bool
    {
        return $this->getGeolocator() instanceof GeolocatorAdapterInterface;
    }

    /**
     * Checks if the given Geolocator service is supported.
     *
     * @param GeolocatorAdapterInterface|null $geolocator The given Geolocator service.
     *
     * @return bool Is the given Geolocator service supported?
     */
    public function supports(?GeolocatorAdapterInterface $geolocator): bool
    {
        // The case where the Geolocator geolocator_id is not used in the project.
        if (null === $geolocator) {
            return true;
        }

        return $geolocator instanceof GeolocatorAdapterInterface;
    }
}
