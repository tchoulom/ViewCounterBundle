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
            return $this->isNewDailyView($viewCounter);
        }

        return false;
    }

    /**
     * Checks whether this is a new daily view.
     *
     * @param ViewCounterInterface $viewCounter
     *
     * @return bool
     */
    protected function isNewDailyView(ViewCounterInterface $viewCounter)
    {
        // Current date
        $currentViewDate = (new \DateTime('now'))->format('Y-m-d H:i:s');
        $currentTimestamp = strtotime($currentViewDate);

        // Tomorrow Date
        $viewDate = clone $viewCounter->getViewDate();
        $tomorrowDate = $viewDate->add(new \DateInterval('P1D'));

        // Sets tomorrow Date at midnight
        $tomorrowDate->setTime(0, 0, 0);
        $tomorrowTimestamp = strtotime($tomorrowDate->format('Y-m-d H:i:s'));

        return $currentTimestamp >= $tomorrowTimestamp;
    }
}