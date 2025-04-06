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

namespace Tchoulom\ViewCounterBundle\Builder;

use Tchoulom\ViewCounterBundle\Adapter\Geolocator\GeolocatorAdapterInterface;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Statistics\Page;
use Tchoulom\ViewCounterBundle\Util\ReflectionExtractor;

/**
 * Class FileStatsBuilder
 *
 * Builds the file statistics.
 */
class FileStatsBuilder
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
     * The Geolocator.
     *
     * @var GeolocatorAdapterInterface
     */
    protected $geolocator;

    /**
     * FileStatsBuilder constructor.
     *
     * @param GeolocatorAdapterInterface $geolocator
     */
    public function __construct(GeolocatorAdapterInterface $geolocator)
    {
        $this->geolocator = $geolocator;
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
     * @param array $contents The contents.
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return self
     */
    public function build(array $contents, ViewCounterInterface $viewcounter): self
    {
        $page = $viewcounter->getPage();
        $this->contents = $contents;
        $this->class = ReflectionExtractor::getClassNamePluralized($page);
        $this->stats = $this->buildPage($page, $viewcounter);

        return $this;
    }

    /**
     * Builds the page.
     *
     * @param ViewCountable $pageRef The page ref.
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return array
     */
    public function buildPage(ViewCountable $pageRef, ViewCounterInterface $viewcounter): array
    {
        $pageId = $pageRef->getId();

        if (isset($this->contents[$this->class][$pageId])) {
            $page = $this->contents[$this->class][$pageId];
        } else {
            $page = new Page($pageId);
        }

        $page->buildYear($viewcounter);
        if ($this->geolocator->canGeolocate()) {
            $page->buildCountry($this->geolocator, $viewcounter);
        }

        $this->contents[$this->class][$pageId] = $page;
        $this->page = $page;

        return $this->contents;
    }
}
