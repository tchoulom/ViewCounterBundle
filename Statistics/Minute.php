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
 * Class Minute
 */
class Minute
{
    protected $name;
    protected $total = 0;

    use SecondTrait;

    /**
     * Minute constructor.
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
     * Builds the minute.
     *
     * @return $this
     */
    public function build()
    {
        $this->total++;

        $second = $this->getSecond();
        $secondName = strtolower($second->getName());
        $this->$secondName = $second->build();

        return $this;
    }

    /**
     * Gets the second.
     *
     * @param null $secondName
     *
     * @return Second
     */
    public function getSecond($secondName = null)
    {
        if (null == $secondName) {
            $secondName = 's' . Date::getSecond();
        }

        $getSecond = 'get' . ucfirst($secondName);
        $second = $this->$getSecond();

        if (!$second instanceof Second) {
            $second = new Second($secondName, 0);
        }

        return $second;
    }
}