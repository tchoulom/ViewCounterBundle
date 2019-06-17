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

namespace Tchoulom\ViewCounterBundle\Statistics;

use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class Day
 */
class Day
{
    protected $name;
    protected $total = 0;
    protected $date;

    /**
     * Day constructor.
     *
     * @param $name
     * @param $total
     */
    public function __construct($name, $total)
    {
        $this->name = $name;
        $this->total = $total;
    }

    /**
     * Gets the name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name.
     *
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets the date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date.
     *
     * @param \DateTimeInterface $date
     *
     * @return $this
     */
    public function setDate(\DateTimeInterface $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Gets the total.
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Sets the total.
     *
     * @param $total
     *
     * @return $this
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Builds the day.
     *
     * @return $this
     */
    public function build()
    {
        $this->total++;
        $this->date = Date::getNowDate();

        return $this;
    }
}