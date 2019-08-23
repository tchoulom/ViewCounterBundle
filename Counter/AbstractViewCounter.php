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

namespace Tchoulom\ViewCounterBundle\Counter;

use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Manager\CounterManager;
use Tchoulom\ViewCounterBundle\Model\ViewcounterConfig;
use Tchoulom\ViewCounterBundle\Statistics\Statistics;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class AbstractViewCounter
 */
abstract class AbstractViewCounter
{
    /**
     * CounterManager
     */
    protected $counterManager;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var Statistics
     */
    protected $statistics;

    /**
     * The View counter configs.
     *
     * @var ViewcounterConfig
     */
    protected $viewcounterConfig;

    /**
     * The viewCounter
     */
    protected $viewCounter = null;

    /**
     * The class namespace
     */
    protected $class = null;

    /**
     * The property
     */
    protected $property = null;

    /**
     * The current Page
     */
    protected $page = null;

    const INCREMENT_EACH_VIEW = 'increment_each_view';
    const DAILY_VIEW = 'daily_view';
    const UNIQUE_VIEW = 'unique_view';
    const HOURLY_VIEW = 'hourly_view';
    const WEEKLY_VIEW = 'weekly_view';
    const MONTHLY_VIEW = 'monthly_view';
    const YEARLY_VIEW = 'yearly_view';

    /**
     * AbstractViewCounter constructor.
     *
     * @param CounterManager $counterManager
     * @param RequestStack $requestStack
     * @param ViewcounterConfig $viewcounterConfig
     */
    public function __construct(CounterManager $counterManager, RequestStack $requestStack, ViewcounterConfig $viewcounterConfig)
    {
        $this->counterManager = $counterManager;
        $this->requestStack = $requestStack;
        $this->viewcounterConfig = $viewcounterConfig;
    }

    /**
     * Determines whether the view is new.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return mixed
     */
    abstract public function isNewView(ViewCounterInterface $viewCounter);

    /**
     * Loads the ViewCounter.
     *
     * @param ViewCountable $page The counted object(a tutorial or course...)
     * @return $this
     */
    protected function loadViewCounter(ViewCountable $page)
    {
        $this->counterManager->loadMetadata($page);
        $this->property = $this->counterManager->getProperty();
        $this->class = $this->counterManager->getClass();

        $viewCounter = $this->counterManager->findOneBy($criteria = [$this->property => $page, 'ip' => $this->getClientIp()], $orderBy = null, $limit = null, $offset = null);

        if ($viewCounter instanceof ViewCounterInterface) {
            $this->viewCounter = $viewCounter;
        } else {
            $this->viewCounter = $this->createViewCounterObject();
        }

        return $this;
    }

    /**
     * Gets the ViewCounter.
     *
     * @param ViewCountable null $page The counted object(a tutorial or course...)
     *
     * @return ViewCounterInterface
     */
    public function getViewCounter(ViewCountable $page = null)
    {
        if (!$this->viewCounter instanceof ViewCounterInterface) {
            $this->loadViewCounter($page);
        }

        return $this->viewCounter;
    }

    /**
     * Gets the page Views.
     *
     * @param ViewCountable $page The counted object(a tutorial or course...)
     *
     * @return int
     */
    public function getViews(ViewCountable $page)
    {
        $viewCounter = $this->getViewCounter($page);

        if (null == $viewCounter || $this->isNewView($viewCounter)) {
            return $page->getViews() + 1;
        }

        return $page->getViews();
    }

    /**
     * Saves the View
     *
     * @param ViewCountable $page The counted object(a tutorial or course...)
     *
     * @return ViewCountable
     */
    public function saveView(ViewCountable $page)
    {
        $viewcounter = $this->getViewCounter($page);

        if ($this->isNewView($viewcounter)) {
            $views = $this->getViews($page);
            $viewcounter->setIp($this->getClientIp());
            $setPage = 'set' . ucfirst($this->getProperty());
            $viewcounter->$setPage($page);
            $viewcounter->setViewDate($this->getNowDate());

            $page->setViews($views);

            $this->counterManager->save($viewcounter);
            $this->counterManager->save($page);

            // Statistics
            if (true === $this->getUseStats()) {
                $this->handleStatistics($viewcounter);
            }
        }

        return $page;
    }

    /**
     * Handles statistics.
     *
     * @param ViewCounterInterface $viewcounter
     */
    public function handleStatistics(ViewCounterInterface $viewcounter)
    {
        $getPage = 'get' . ucfirst($this->getProperty());
        $page = $viewcounter->$getPage();

        $this->statistics->register($page);
    }

    /**
     * Gets the current Request.
     *
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Gets the view strategy.
     *
     * @return int|string
     */
    protected function getViewStrategy()
    {
        return $this->viewcounterConfig->getViewStrategy();
    }

    /**
     * Gets the use_stats value.
     *
     * @return boolean
     */
    protected function getUseStats()
    {
        return $this->viewcounterConfig->getUseStats();
    }

    /**
     * Creates the ViewCounter Object from the class namespace.
     *
     * @return ViewCounterInterface
     */
    protected function createViewCounterObject()
    {
        $class = $this->getClass();
        $viewCounterObject = new $class();

        return $viewCounterObject;
    }

    /**
     * Gets the class namespace.
     *
     * @return null
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * Gets the property.
     *
     * @return null
     */
    protected function getProperty()
    {
        return $this->property;
    }

    /**
     * Sets the current Page   The counted object(a tutorial or course...)
     *
     * @param ViewCountable $page
     */
    protected function setPage(ViewCountable $page)
    {
        $this->page = $page;
    }

    /**
     * Gets the current Page   The counted object(a tutorial or course...)
     *
     * @return ViewCountable|null
     */
    protected function getPage()
    {
        return $this->page;
    }

    /**
     * Gets now Date.
     *
     * @return \DateTime
     */
    protected function getNowDate()
    {
        return Date::getNowDate();
    }

    /**
     * Gets the client IP.
     *
     * @return null|string
     */
    public function getClientIp()
    {
        return $this->getRequest()->getClientIp();
    }

    /**
     * Sets the statistics.
     *
     * @param Statistics $statistics
     *
     * @return $this
     */
    public function setStatistics(Statistics $statistics)
    {
        $this->statistics = $statistics;

        return $this;
    }
}