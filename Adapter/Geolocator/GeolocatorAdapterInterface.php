<?php

namespace Tchoulom\ViewCounterBundle\Adapter\Geolocator;


/**
 * Class GeolocatorAdapterInterface
 */
interface GeolocatorAdapterInterface
{
    /**
     * Gets the Geolocator service.
     *
     * @return GeolocatorInterface|null The Geolocator service
     */
    public function getGeolocator();

    /**
     * The record returned.
     *
     * @return mixed The record
     */
    public function getRecord();

    /**
     * Gets the continent name.
     *
     * @return string The continent name
     */
    public function getContinent(): string;

    /**
     * Gets the country name.
     *
     * @return string The country name
     */
    public function getCountry(): string;

    /**
     * Gets the region name.
     *
     * @return string The region name
     */
    public function getRegion(): string;

    /**
     * Gets the city name.
     *
     * @return string The city name
     */
    public function getCity(): string;

    /**
     * Allows to check if we can geolocate.
     *
     * @return bool Can use the Geolocator service?
     */
    public function canGeolocate(): bool;

    /**
     * Checks if the given Geolocator service is supported.
     *
     * @param $geolocator The given Geolocator service.
     *
     * @return bool Is the given Geolocator service supported?
     */
    public function supports($geolocator);
}