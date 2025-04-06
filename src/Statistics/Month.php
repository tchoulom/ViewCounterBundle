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

use Tchoulom\ViewCounterBundle\Entity\ViewCounterInterface;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class Month
 */
class Month
{
    /**
     * The month number.
     *
     * @var int
     */
    protected $monthNumber;

    /**
     * The total.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * The weeks.
     *
     * @var Week[]
     */
    protected $weeks = [];

    /**
     * Month constructor.
     */
    public function __construct()
    {
        $this->monthNumber = Date::getNowMonth();
    }

    /**
     * Gets the number of month.
     *
     * @return int
     */
    public function getMonthNumber(): int
    {
        return $this->monthNumber;
    }

    /**
     * Sets the number of month.
     *
     * @param int $monthNumber
     *
     * @return self
     */
    public function setMonthNumber(int $monthNumber): self
    {
        $this->monthNumber = $monthNumber;

        return $this;
    }

    /**
     * Gets the total.
     *
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * Sets the total.
     *
     * @param int $total
     *
     * @return self
     */
    public function setTotal(int $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Gets the weeks.
     *
     * @return Week[]
     */
    public function getWeeks(): array
    {
        return $this->weeks;
    }

    /**
     * Builds the week.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return self
     */
    public function buildWeek(ViewCounterInterface $viewcounter): self
    {
        $this->total++;
        $weekNumber = intval($viewcounter->getViewDate()->format('W'));

        if (isset($this->weeks[$weekNumber])) {
            $week = $this->weeks[$weekNumber];
        } else {
            $week = new Week();
        }

        $this->weeks[$weekNumber] = $week->buildDay($viewcounter);

        return $this;
    }
}
