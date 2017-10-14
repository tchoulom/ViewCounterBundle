<?php

namespace Tchoulom\ViewCounterBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * Class ViewCounter.
 */
class ViewCounter
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var RequestStack
     */
    public $requestStack;

    /**
     * ViewCounter constructor.
     *
     * @param EntityManagerInterface $em
     * @param RequestStack $requestStack
     */
    public function __construct(EntityManagerInterface $em, RequestStack $requestStack)
    {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    /**
     * Determines whether the view is new.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return bool
     */
    public function isNewView(ViewCounterInterface $viewCounter)
    {
        if (null == $viewCounter->getViewDate()) {
            return true;
        }

        // First View date
        $firstViewDate = $viewCounter->getViewDate()->format('Y-m-d H:i:s');
        $firstViewTimetamp = strtotime($firstViewDate);

        // Current date
        $currentViewDate = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $currentTimetamp = strtotime($currentViewDate);

        // Tommorow Date
        $tommorowDateOfCourseViewDate = $viewCounter->getViewDate()->add(new \DateInterval('P1D'));
        // Sets tomorrow Date at midnight
        $tommorowDateOfCourseViewDate->setTime(0, 0, 0);
        $tomorrowTimetampOfCourseViewDate = strtotime($tommorowDateOfCourseViewDate->format('Y-m-d H:i:s'));

        return $currentTimetamp >= $tomorrowTimetampOfCourseViewDate;
    }

    /**
     * Gets the ViewCounter.
     *
     * @param ViewCountable $page The counted object(a tutorial or course...)
     *
     * @return null|object
     */
    public function getViewCounter(ViewCountable $page)
    {
        $metadata = $this->em->getClassMetadata(get_class($page));
        $property = $metadata->getAssociationMappings()['viewCounters']['mappedBy'];
        $class = $metadata->getAssociationMappings()['viewCounters']['targetEntity'];

        $viewcounter = $this->em->getRepository($class)->findOneBy($criteria = [$property => $page, 'ip' => $this->getRequest()->getClientIp()], $orderBy = null, $limit = null, $offset = null);

        return $viewcounter;
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
}