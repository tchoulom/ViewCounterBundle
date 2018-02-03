<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@yahoo.fr>
 *
 * (c) Ernest TCHOULOM <https://www.tchoulom.com/>
 *
 * This source file is subject to the MIT license.
 */

namespace Tchoulom\ViewCounterBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * Class AbstractViewCounter
 */
abstract class AbstractViewCounter
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

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
     * ViewCounter constructor.
     *
     * @param EntityManagerInterface $em
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManagerInterface $em, RequestStack $requestStack, array $viewInterval)
    {
        $this->em = $em;
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
    abstract protected function isNewView(ViewCounterInterface $viewCounter);

    /**
     * Loads the ViewCounter.
     *
     * @param ViewCountable $page The counted object(a tutorial or course...)
     */
    public function loadViewCounter(ViewCountable $page)
    {
        $metadata = $this->em->getClassMetadata(get_class($page));
        $property = $metadata->getAssociationMappings()['viewCounters']['mappedBy'];
        $class = $metadata->getAssociationMappings()['viewCounters']['targetEntity'];

        $this->viewCounter = $this->em->getRepository($class)->findOneBy($criteria = [$property => $page, 'ip' => $this->getRequest()->getClientIp()], $orderBy = null, $limit = null, $offset = null);
    }

    /**
     * Gets the ViewCounter.
     *
     * @param null $page The counted object(a tutorial or course...)
     *
     * @return null|\Tchoulom\ViewCounterBundle\Entity\ViewCounter
     */
    public function getViewCounter($page = null)
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
     * Gets the current Request.
     *
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->requestStack->getCurrentRequest();
    }

    /**
     * Gets view interval name.
     *
     * @return int|string
     */
    public function getViewIntervalName()
    {
        $viewIntervalName = '';
        foreach ($this->viewInterval[0] as $key => $vi) {
            $viewIntervalName = $key;
            break;
        }

        return $viewIntervalName;
    }
}