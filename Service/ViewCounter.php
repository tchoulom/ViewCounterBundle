<?php

namespace Tchoulom\ViewCounterBundle\Service;

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Model\ViewCountable;

/**
 * Class ViewCounter.
 */
class ViewCounter
{
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
     * Gets the page Views.
     *
     * @param ViewCountable $page The counted object(a tutorial or course...)
     * @param ViewCounterInterface $viewCounter The viewCounter object
     *
     * @return int
     */
    public function getViews(ViewCountable $page, ViewCounterInterface $viewCounter)
    {
        if ($this->isNewView($viewCounter)) {
            return $page->getViews() + 1;
        }

        return $page->getViews();
    }
}