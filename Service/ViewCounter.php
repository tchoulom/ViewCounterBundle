<?php

namespace Tchoulom\ViewCounterBundle\Service;

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;

/**
 * Class ViewCounter
 */
class ViewCounter extends AbstractViewCounter
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

        if ('unique_view' === $this->getViewIntervalName()) {
            return false;
        }

        if ('daily_view' === $this->getViewIntervalName()) {
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

        return false;
    }
}