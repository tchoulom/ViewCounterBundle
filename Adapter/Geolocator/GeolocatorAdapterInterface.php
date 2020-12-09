<?php

namespace Tchoulom\ViewCounterBundle\Adapter\Geolocator;


/**
 * Class GeolocatorAdapter
 */
interface GeolocatorAdapterInterface
{
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
}
