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

namespace Tchoulom\ViewCounterBundle\Counter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;
use Tchoulom\ViewCounterBundle\Manager\CounterManager;
use Tchoulom\ViewCounterBundle\Model\ViewcounterConfig;
use Tchoulom\ViewCounterBundle\Manager\StatsManager;
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
     * @var StatsManager
     */
    protected $statsManager;

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

    const ON_REFRESH = 'on_refresh';
    const DAILY_VIEW = 'daily_view';
    const UNIQUE_VIEW = 'unique_view';
    const HOURLY_VIEW = 'hourly_view';
    const WEEKLY_VIEW = 'weekly_view';
    const MONTHLY_VIEW = 'monthly_view';
    const YEARLY_VIEW = 'yearly_view';
    const VIEW_PER_MINUTE = 'view_per_minute';
    const VIEW_PER_SECOND = 'view_per_second';

    /**
     * AbstractViewCounter constructor.
     *
     * @param CounterManager $counterManager
     * @param RequestStack $requestStack
     * @param ViewcounterConfig $viewcounterConfig
     */
    public function __construct(
        CounterManager    $counterManager,
        RequestStack      $requestStack,
        ViewcounterConfig $viewcounterConfig
    )
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
     *
     * @return ViewCounterInterface
     */
    protected function loadViewCounter(ViewCountable $page): ViewCounterInterface
    {
        $this->counterManager->loadMetadata($page);
        $this->property = $this->counterManager->getProperty();
        $this->class = $this->counterManager->getClass();
        $clientIP = $this->getClientIp();

        $viewCounter = $this->counterManager->findOneBy($criteria = [$this->property => $page, 'ip' => $clientIP],
            $orderBy = ['viewDate' => 'DESC'], $limit = null, $offset = null);

        if ($viewCounter instanceof ViewCounterInterface) {
            return $viewCounter;
        }

        return $this->createViewCounterObject($page);
    }

    /**
     * Creates the ViewCounter Object from the class namespace.
     *
     * @param ViewCountable $page The given page.
     *
     * @return ViewCounterInterface
     */
    protected function createViewCounterObject(ViewCountable $page): ViewCounterInterface
    {
        $this->counterManager->loadMetadata($page);
        $class = $this->counterManager->getClass();
        $viewCounterObject = new $class();

        return $viewCounterObject;
    }

    /**
     * Gets the ViewCounter.
     *
     * @param ViewCountable null $page The counted object(a tutorial or course...)
     *
     * @return ViewCounterInterface
     */
    public function getViewCounter(ViewCountable $page = null): ViewCounterInterface
    {
        $viewCounter = $this->loadViewCounter($page);

        return $viewCounter;
    }

    /**
     * Gets the page Views.
     *
     * @param ViewCountable $page The counted object(a tutorial or course...)
     *
     * @return int
     */
    public function getViews(ViewCountable $page): int
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
     *
     * @throws \ReflectionException
     */
    public function saveView(ViewCountable $page): ViewCountable
    {
        $viewcounter = $this->getViewCounter($page);

        if ($this->isNewView($viewcounter)) {
            $viewcounter = $this->createViewCounterObject($page);
            $views = $this->getViews($page);

            $viewcounter->setIp($this->getClientIp());
            $property = $this->getProperty();
            $viewcounter->setProperty($property);
            $viewcounter->setPage($page);
            $viewcounter->setViewDate(Date::getNowDate());

            $page->setViews($views);

            $this->counterManager->save($viewcounter);
            $this->counterManager->save($page);

            // Statistics
            if (true === $this->isStatsEnabled()) {
                $this->handleStatistics($viewcounter);
            }
        }

        return $page;
    }

    /**
     * Handles statistics.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @throws \ReflectionException
     */
    public function handleStatistics(ViewCounterInterface $viewcounter)
    {
        $this->statsManager->register($viewcounter);
    }

    /**
     * Gets the current Request.
     *
     * @return Request|null
     */
    protected function getRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Gets the view strategy.
     *
     * @return mixed
     */
    protected function getViewStrategy()
    {
        $viewcounterNodeConfig = $this->viewcounterConfig->getViewcounterNodeConfig();
        $viewStrategy = $viewcounterNodeConfig->getViewStrategy();

        return $viewStrategy;
    }

    /**
     * Is stats enabled ?
     *
     * @return bool Is stats enabled ?
     */
    protected function isStatsEnabled(): bool
    {
        $statisticsNodeConfig = $this->viewcounterConfig->getStatisticsNodeConfig();
        $isStatsEnabled = $statisticsNodeConfig->isStatsEnabled();

        return $isStatsEnabled;
    }

    /**
     * Gets the class namespace.
     *
     * @return mixed
     */
    protected function getClass()
    {
        return $this->class;
    }

    /**
     * Gets the property.
     *
     * @return mixed
     */
    protected function getProperty()
    {
        return $this->property;
    }

    /**
     * Sets the current Page   The counted object(a tutorial or course...)
     *
     * @param ViewCountable $page
     *
     * @return self
     */
    protected function setPage(ViewCountable $page): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Gets the current Page   The counted object(a tutorial or course...)
     *
     * @return ViewCountable|null
     */
    protected function getPage(): ?ViewCountable
    {
        return $this->page;
    }

    /**
     * Gets the client IP.
     *
     * @return null|string
     */
    public function getClientIp(): ?string
    {
        return $this->getRequest()->getClientIp();
    }

    /**
     * Sets the StatsManager.
     *
     * @param StatsManager $statsManager
     *
     * @return self
     */
    public function setStatsManager(StatsManager $statsManager): self
    {
        $this->statsManager = $statsManager;

        return $this;
    }
}
