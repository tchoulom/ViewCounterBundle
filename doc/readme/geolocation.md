## Step 6: The Geolocation

Some bundles can be used to have a geolocation system in your project.
These bundles usually use the ip address in order to geolocate the visitor of the web page.

For the purposes of this documentation, we will use this bundle, for example:

**gpslab/geoip2** :  [https://github.com/gpslab/geoip2](https://github.com/gpslab/geoip2)

You can read the documentation for installing and using this bundle if you want to use it.

Otherwise, you can use another geolocation bundle according to your preferences.

*****Create the "Geolocator" service that will allow you to manage geolocation data*****

```php
<?php

namespace App\Service;

use GeoIp2\Database\Reader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Adapter\Geolocator\GeolocatorAdapterInterface;

/**
 * Class Geolocator
 *
 * This service must implements the "GeolocatorAdapterInterface".
 */
class Geolocator implements GeolocatorAdapterInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * Geolocator constructor.
     *
     * @param RequestStack $requestStack
     * @param Reader $reader
     */
    public function __construct(RequestStack $requestStack, Reader $reader)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->reader = $reader;
    }

    /**
     * Gets the record.
     * 
     * @return \GeoIp2\Model\City|mixed
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function getRecord()
    {
        $clientIp = $this->request->getClientIp();

        return $this->reader->city($clientIp);
    }

    /**
     * Gets the continent.
     *
     * @return string
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function getContinent(): string
    {
        return $this->getRecord()->continent->name;
    }

    /**
     * Gets the country.
     * 
     * @return string
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function getCountry(): string
    {
        return $this->getRecord()->country->name;
    }

    /**
     * Gets the region.
     * 
     * @return string
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function getRegion(): string
    {
        return $this->getRecord()->subdivisions[0]->names['en'];
    }

    /**
     * Gets the city.
     * 
     * @return string
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function getCity(): string
    {
        return $this->getRecord()->city->name;
    }
}
```

Your Geolocation service must implement the "Tchoulom\ViewCounterBundle\Adapter\Geolocator\GeolocatorAdapterInterface" interface.

you are free to improve the above "Geolocator" service, in particular to verify the existence of geolocation data.

You can go to this step for the use of geolocation data [Search for geolocation data](statistics-finder.md#search-for-geolocation-data).
