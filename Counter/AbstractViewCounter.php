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
     * The View interval.
     * @var array
     */
    protected $viewInterval;

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

    /**
     * AbstractViewCounter constructor.
     *
     * @param CounterManager $counterManager
     * @param RequestStack $requestStack
     * @param array $viewInterval
     */
    public function __construct(CounterManager $counterManager, RequestStack $requestStack, array $viewInterval)
    {
        $this->counterManager = $counterManager;
        $this->requestStack = $requestStack;
        $this->viewInterval = $viewInterval;
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

        $this->viewCounter = $this->counterManager->findOneBy($criteria = [$this->property => $page, 'ip' => $this->getIp()], $orderBy = null, $limit = null, $offset = null);

        return $this;
    }

    /**
     * Gets the ViewCounter.
     *
     * @param ViewCountable null $page The counted object(a tutorial or course...)
     *
     * @return null|\Tchoulom\ViewCounterBundle\Entity\ViewCounter
     */
    public function getViewCounter(ViewCountable $page = null)
    {
        if (null == $this->viewCounter) {
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
        $viewCounterObject = $this->createViewCounterObject();
        $viewcounter = null != $viewcounter ? $viewcounter : $viewCounterObject;

        if ($this->isNewView($viewcounter)) {
            $views = $this->getViews($page);
            $viewcounter->setIp($this->getIp());
            $setPage = 'set' . ucfirst($this->getProperty());
            $viewcounter->$setPage($page);
            $viewcounter->setViewDate($this->getNowDate());

            $page->setViews($views);

            $this->counterManager->save($viewcounter);
            $this->counterManager->save($page);
        }

        return $page;
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
     * Gets view interval name.
     *
     * @return int|string
     */
    protected function getViewIntervalName()
    {
        $viewIntervalName = '';
        foreach ($this->viewInterval as $key => $vi) {
            $viewIntervalName = $key;
            break;
        }

        return $viewIntervalName;
    }

    /**
     * Creates the ViewCounter Object from the class namespace.
     *
     * @return mixed
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
     * Gets the user IP.
     *
     * @return null|string
     */
    public function getIp()
    {
        return $this->getRequest()->getClientIp();
    }
}