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
 * Class Day
 */
class Day
{
    /**
     * The Day name.
     *
     * @var string
     */
    protected $name;

    /**
     * The total.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * The Date.
     *
     * @var \DateTimeInterface
     */
    protected $date;

    use HourTrait;

    /**
     * Day constructor.
     *
     * @param string $name
     * @param int $total
     */
    public function __construct(string $name, int $total)
    {
        $this->name = $name;
        $this->total = $total;
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the date.
     *
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * Sets the date.
     *
     * @param \DateTimeInterface $date
     *
     * @return self
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
     * Builds the day.
     *
     * @param ViewCounterInterface $viewcounter The viewcounter entity.
     *
     * @return self
     *
     * @throws \Exception
     */
    public function build(ViewCounterInterface $viewcounter): self
    {
        $this->total++;
        $this->date = $viewcounter->getViewDate();
        $hourName = 'h' . $viewcounter->getViewDate()->format('H');
        $hour = $this->getHour($hourName);
        $hourName = strtolower($hour->getName());
        $this->$hourName = $hour->build($viewcounter);

        return $this;
    }

    /**
     * Gets the hour.
     *
     * @param string|null $hourName The hour name.
     *
     * @return Hour                 The hour.
     */
    public function getHour(?string $hourName = null): Hour
    {
        if (null == $hourName) {
            $hourName = 'h' . Date::getHour();
        }

        $hour = $this->get($hourName);
        if (!$hour instanceof Hour) {
            $hour = new Hour($hourName, 0);
        }

        return $hour;
    }
}
