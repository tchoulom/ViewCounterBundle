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

/**
 * Class StatBuilder
 *
 * Builds the statistics.
 */
class StatBuilder
{
    /**
     * The contents.
     *
     * @var array
     */
    protected $contents;

    /**
     * The given class.
     *
     * @var string
     */
    protected $class;

    /**
     * The page.
     *
     * @var Page
     */
    protected $page;

    /**
     * The stats.
     *
     * @var array
     */
    protected $stats = [];

    /**
     * The Geolocator Adapter
     *
     * @var GeolocatorAdapterInterface
     */
    protected $geolocatorAdapter;

    /**
     * StatBuilder constructor.
     *
     * @param GeolocatorAdapterInterface $geolocatorAdapter
     */
    public function __construct(GeolocatorAdapterInterface $geolocatorAdapter)
    {
        $this->geolocatorAdapter = $geolocatorAdapter;
    }

    /**
     * Gets the contents.
     *
     * @return array
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * Sets the contents.
     *
     * @param array $contents
     *
     * @return self
     */
    public function setContents(array $contents): self
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Gets the class name.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets the class name.
     *
     * @param string $class
     *
     * @return self
     */
    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Gets the page.
     *
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * Sets the page.
     *
     * @param Page $page
     *
     * @return self
     */
    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Gets the stats.
     *
     * @return array
     */
    public function getStats(): array
    {
        return $this->stats;
    }

    /**
     * Sets the stats.
     *
     * @param array $stats
     *
     * @return self
     */
    public function setStats(array $stats): self
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Builds the stats.
     *
     * @param array $contents
     * @param string $class
     * @param int $pageId
     *
     * @return self
     */
    public function build(array $contents, string $class, int $pageId): self
    {
        $this->contents = $contents;
        $this->class = $class;
        $this->stats = $this->buildPage($pageId);

        return $this;
    }

    /**
     * Builds the page.
     *
     * @param int $pageId
     *
     * @return array
     */
    public function buildPage(int $pageId): array
    {
        if (isset($this->contents[$this->class][$pageId])) {
            $page = $this->contents[$this->class][$pageId];
        } else {
            $page = new Page($pageId);
        }

        $page->buildYear();
        if ($this->geolocatorAdapter->canGeolocate()) {
            $page->buildCountry($this->geolocatorAdapter);
        }

        $this->contents[$this->class][$pageId] = $page;
        $this->page = $page;

        return $this->contents;
    }
}
