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
 * Class Page
 */
class Page
{
    protected $id;
    protected $years = [];

    /**
     * Page constructor.
     *
     * @param $id
     * @param array $years
     */
    public function __construct($id, array $years)
    {
        $this->id = $id;
        $this->years = $years;
    }

    /**
     * Gets the Id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the years.
     *
     * @return array
     */
    public function getYears()
    {
        return $this->years;
    }

    /**
     * Sets the years.
     *
     * @param $years
     *
     * @return $this
     */
    public function setYears($years)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * Builds the year.
     *
     * @return $this
     */
    public function buildYear()
    {
        $yearNumber = Date::getNowYear();

        if (isset($this->years[$yearNumber])) {
            $year = $this->years[$yearNumber];
        } else {
            $year = new Year([], 0);
        }

        $this->years[$yearNumber] = $year->buildMonth();

        return $this;
    }
}