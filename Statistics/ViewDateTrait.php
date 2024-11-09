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

namespace Tchoulom\ViewCounterBundle\Statistics;


use Tchoulom\ViewCounterBundle\Statistics\Date as ViewDate;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Trait ViewDateTrait
 */
trait ViewDateTrait
{
    /**
     * The view dates.
     *
     * @var array
     */
    protected $viewDates = [];

    /**
     * Gets the view dates.
     *
     * @return array
     */
    public function getViewDates(): array
    {
        return $this->viewDates;
    }

    /**
     * Sets the view dates.
     *
     * @param array $viewDates The view dates.
     *
     * @return self
     */
    public function setViewDates(array $viewDates): self
    {
        $this->viewDates = $viewDates;

        return $this;
    }

    /**
     * Builds the view date.
     */
    public function buildViewDate(): void
    {
        $date = $this->viewcounter->getViewDate();
        $formattedDate = $date->format('Y-m-d H:i:s');

        if (isset($this->viewDates[$formattedDate])) {
            $date = $this->viewDates[$formattedDate];
            $date->build();
        } else {
            $date = new ViewDate(1, $date);
        }

        $this->viewDates[$formattedDate] = $date;
    }
}
