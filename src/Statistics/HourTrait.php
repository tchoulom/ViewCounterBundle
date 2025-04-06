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

/**
 * Trait HourTrait
 */
trait HourTrait
{
    protected $h00;
    protected $h01;
    protected $h02;
    protected $h03;
    protected $h04;
    protected $h05;
    protected $h06;
    protected $h07;
    protected $h08;
    protected $h09;
    protected $h10;
    protected $h11;
    protected $h12;
    protected $h13;
    protected $h14;
    protected $h15;
    protected $h16;
    protected $h17;
    protected $h18;
    protected $h19;
    protected $h20;
    protected $h21;
    protected $h22;
    protected $h23;

    /**
     * Gets the hour.
     *
     * @param string $hourName The given hour name.
     *
     * @return Hour|null       The hour.
     */
    public function get(string $hourName): ?Hour
    {
        return $this->$hourName;
    }
}
