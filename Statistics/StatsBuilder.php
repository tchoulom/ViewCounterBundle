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

/**
 * Class StatsBuilder
 *
 * Builds the statistics.
 */
class StatsBuilder
{
    protected $contents;
    protected $class;
    protected $page;
    protected $stats = [];

    /**
     * StatsBuilder constructor.
     *
     * @param $contents The stats contents
     * @param $class
     */
    public function __construct($contents, $class)
    {
        $this->contents = $contents;
        $this->class = $class;
    }

    /**
     * Gets the contents.
     *
     * @return array
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Sets the contents.
     *
     * @param array $contents
     *
     * @return $this
     */
    public function setContents(array $contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Gets the class name.
     *
     * @return mixed
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Sets the class name.
     *
     * @param mixed $class
     *
     * @return StatsBuilder
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Gets the page.
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Sets the page.
     *
     * @param Page $page
     *
     * @return $this
     */
    public function setPage(Page $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Gets the stats.
     *
     * @return array
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * Sets the stats.
     *
     * @param array $stats
     *
     * @return $this
     */
    public function setStats(array $stats)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Builds the stats.
     *
     * @param $pageId
     *
     * @return $this
     */
    public function build($pageId)
    {
        $contents = $this->buildPage($pageId);
        $this->stats = $contents;

        return $this;
    }

    /**
     * Builds the page.
     *
     * @param $pageId
     *
     * @return array
     */
    public function buildPage($pageId)
    {
        if (isset($this->contents[$this->class][$pageId])) {
            $page = $this->contents[$this->class][$pageId];
        } else {
            $page = new Page($pageId, []);
        }

        $this->contents[$this->class][$pageId] = $page->buildYear();
        $this->page = $page;

        return $this->contents;
    }
}
