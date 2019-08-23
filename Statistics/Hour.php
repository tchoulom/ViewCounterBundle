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
 * Class Hour
 */
class Hour
{
    protected $name;
    protected $fullHour;
    protected $total = 0;

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
     * Gets the full hour.
     *
     * @return false|string
     */
    public function getFullHour()
    {
        return $this->fullHour;
    }

    /**
     * Sets the full hour.
     *
     * @param false|string $fullHour
     *
     * @return Hour
     */
    public function setFullHour($fullHour)
    {
        $this->fullHour = $fullHour;

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
     * Builds the hour.
     *
     * @return $this
     */
    public function build()
    {
        $this->total++;
        $this->fullHour = Date::getFullHour();

        return $this;
    }
}