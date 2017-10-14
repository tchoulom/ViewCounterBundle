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
            // Current date
            $currentViewDate = (new \DateTime('now'))->format('Y-m-d H:i:s');
            $currentTimestamp = strtotime($currentViewDate);

            // Tomorrow Date
            $tomorrowDate = $viewCounter->getViewDate()->add(new \DateInterval('P1D'));
            // Sets tomorrow Date at midnight
            $tomorrowDate->setTime(0, 0, 0);
            $tomorrowTimestamp = strtotime($tomorrowDate->format('Y-m-d H:i:s'));

            return $currentTimestamp >= $tomorrowTimestamp;
        }

        return false;
    }
}